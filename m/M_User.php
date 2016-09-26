<?php

/*
 * Класс работы с данными пользователей
 */

class M_User
{
    private static $instance;
    private $msql;
    private $sid;
    private $uid;
    private $onlineMap;

    public function __construct()
    {
        $this->msql = M_MSQL::Instance();
        $this->mFunctions = M_Functions::Instance();
        $this->sid = null;
        $this->uid = null;
        $this->onlineMap = null;
    }

    public static function Instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_User();
        }
        return self::$instance;
    }

    /*
     * чистим сессии
     */

    public function ClearSessions()
    {
        $min = date('Y-m-d H:i:s', time() - 3600 * 4);
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        $this->msql->Delete('sessions', $where);
    }

    /*
     * функция логина
     */
    public function Login($email, $password)
    {

        $user = $this->GetByLogin($email);

        if ($user == null) {
            return false;
        }

        $id_user = $user['user_id'];


        if ($user['password'] != md5($password)) {
            return false;
        }

        setcookie('email', $email, time() + 3600 * 24 * 7);
        setcookie('password', md5($password), time() + 3600 * 24 * 7);

        $this->sid = $this->OpenSession($id_user);

        return true;
    }

    /*
    * Определяем пользователя по email
    */

    public function GetByLogin($email)
    {
        $t = "SELECT * FROM users WHERE user_email = '%s'";
        $query = sprintf($t, $email);
        $result = $this->msql->Select($query);
        if (!empty($result)) {
            return $result[0];
        }
        return false;
    }

    /*
    * Открытие новой сессии
    *  результат	- SID
    */

    private function OpenSession($id_user)
    {
        // генерируем SID
        $sid = $this->GenerateStr(10);

        // вставляем SID в БД
        $now = date('Y-m-d H:i:s');
        $session = array();
        $session['user_id'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;
        $this->msql->Insert('sessions', $session);

        // регистрируем сессию в PHP сессии
        $_SESSION['sid'] = $sid;

        // возвращаем SID
        return $sid;
    }

    /*
     * Генерация случайной последовательности
     * $length 		- ее длина
     * результат	- случайная строка
     */
    private function GenerateStr($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }

    /*
     * Logout
     */

    public function Logout()
    {
        setcookie('login', '', time() - 1);
        setcookie('password', '', time() - 1);
        setcookie('email', '', time() - 1);
        unset($_COOKIE['login']);
        unset($_COOKIE['password']);
        unset($_COOKIE['email']);
        unset($_SESSION['sid']);
        $this->sid = null;
        $this->uid = null;
    }

    /*
     * Определяем пользователя
     */

    public function Get($id_user = null)
    {
        if ($id_user == null) {
            $id_user = $this->GetUid();
        }

        if ($id_user == null) {
            return null;
        }

        $t = "SELECT * FROM users WHERE user_id = '%d'";
        $query = sprintf($t, $id_user);
        $result = $this->msql->Select($query);
        return $result[0];
    }

    /*
     * Получение id текущего пользователя
     * результат	- UID
    */

    public function GetUid()
    {
        // Проверка кеша.
        if ($this->uid != null) {
            return $this->uid;
        }

        // Берем по текущей сессии.
        $sid = $this->GetSid();

        if ($sid == null) {
            return null;
        }

        $t = "SELECT user_id FROM sessions WHERE sid = '%s'";
        $query = sprintf($t, $sid);
        $result = $this->msql->Select($query);

        // Если сессию не нашли - значит пользователь не авторизован.
        if (count($result) == 0)
            return null;

        // Если нашли - запоминм ее.
        $this->uid = $result[0]['user_id'];
        return $this->uid;
    }

    /*
     * Функция возвращает идентификатор текущей сессии
     * результат	- SID
     */

    private function GetSid()
    {
        $sid = '';

        // Проверка кеша.
        if ($this->sid != null) {
            return $this->sid;
        }

        // Ищем SID в сессии.
        if (isset($_SESSION['sid'])) {
            $sid = $_SESSION['sid'];
        }
        // Если нашли, попробуем обновить time_last в базе.
        // Заодно и проверим, есть ли сессия там.
        if ($sid != null) {
            $session = array();
            $session['time_last'] = date('Y-m-d H:i:s');
            $t = "sid = '%s'";
            $where = sprintf($t, $sid);
            $affected_rows = $this->msql->Update('sessions', $session, $where);

            if ($affected_rows == 0) {
                $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";
                $query = sprintf($t, $sid);
                $result = $this->msql->Select($query);

                if ($result[0]['count(*)'] == 0)
                    $sid = null;
            }
        }

        // Нет сессии? Ищем логин и md5(пароль) в куках.
        // Т.е. пробуем переподключиться

        if ($sid == null && isset($_COOKIE['email'])) {
            $user = $this->GetByLogin($_COOKIE['email']);

            if ($user != null && $user['password'] == $_COOKIE['password']) {
                $sid = $this->OpenSession($user['user_id']);
            }
        }

        // Запоминаем в кеш.
        if ($sid != null) {
            $this->sid = $sid;
        }
        // Возвращаем, наконец, SID.
        return $sid;
    }

    /*
     * Получаем разрешения для роли
     */

    public function Can($priv, $id_user = null)
    {
        //Получаем роль пользователя
        $role = $this->getRole($id_user);
        //определяем его разрешения
        $privsList = $this->getPermissionsByRole($role['role_id']);
        if ($id_user == null) {
            $id_user = $this->GetUid();
        }

        if ($id_user == null) {
            return false;
        }

        foreach ($privsList as $list) {

            if (strlen($list['name'] == $priv) > 0) {
                return true;
            }
        }
        return false;
    }

    /*
     * Определить роль
     */

    protected function getRole($id_user)
    {
        $query = "SELECT roles.role_id FROM roles,users WHERE users.user_id = '$id_user' AND users.role_id = roles.role_id";

        $name_role = $this->msql->Select($query);
        return $name_role[0];
    }

    /*
     * Все разрешения Роли
     */

    public function getPermissionsByRole($roleId)
    {
        $result = [];
        $role = [];
        $permissions_list = [];
        $role_n = '';

        //Находим привелегию для данной роли
        $query1 = "SELECT privs.controller_name,privs.priv_id,privs.name FROM privs,privs2roles,roles WHERE roles.role_id = '$roleId' AND roles.role_id = privs2roles.role_id AND privs2roles.priv_id = privs.priv_id";

        //Основные привелегии роли
        $primary_permissions_list[] = $this->msql->Select($query1);

        //Находим все основные привелегии роли
        foreach ($primary_permissions_list as $key) {
            foreach ($key as $item) {
                $permissions_list[][0] = $item;
            }
        }

        //Дочерние роли
        $childrenList = $this->getChildrenList();
        //Находим всех "детей"
        $this->getChildrenRecursive($roleId, $childrenList, $result);

        //Находим привелегии для ролей потомков
        foreach ($result as $key => $value) {
            $query = "SELECT role_id FROM roles WHERE role_id = '$key'";
            $role[] = $this->msql->Select($query);
        }

        foreach ($role as $keys => $values) {

            if (!empty($values)) {
                $role_n = $values[0]['role_id'];
            }

            $queryss = "SELECT privs.controller_name,privs.priv_id,privs.name  FROM privs,privs2roles WHERE privs2roles.role_id = '$role_n' AND privs2roles.priv_id = privs.priv_id";
            $permissions_list[] = $this->msql->Select($queryss);

        }

        $permissions_final = $this->getAllPrivs($permissions_list);

        return $permissions_final;
    }

    public function getChildrenList()
    {
        $query = "SELECT * FROM auth_item_child";

        $result = $this->msql->Select($query);
        $parents = [];

        foreach ($result as $row) {
            $parents[$row['parent']][] = $row['child'];
        }

        return $parents;
    }

    /*
     * Все потомки роли
     */

    protected function getChildrenRecursive($name, $childrenList, &$result)
    {
        if (isset($childrenList[$name])) {
            foreach ($childrenList[$name] as $child) {
                $result[$child] = true;
                $this->getChildrenRecursive($child, $childrenList, $result);
            }
        }
    }

    /*
     * Все потомки роли рекурсивно
     */

    protected function getAllPrivs($privs)
    {
        $result = [];
        if (is_array($privs)) {

            foreach ($privs as $key => $value) {
                foreach ($value as $keys => $values) {
                    $result[] = $values;
                }
            }
        }
        return $result;
    }

    /*
     * Проверка активности пользователя
     *  $id_user		- идентификатор
     * результат	- true если online
     */

    public function IsOnline($id_user)
    {
        if ($this->onlineMap == null) {
            $t = "SELECT DISTINCT user_id FROM sessions";
            $query = sprintf($t, $id_user);
            $result = $this->msql->Select($query);

            foreach ($result as $item) {
                $this->onlineMap[$item['user_id']] = true;
            }
        }

        return ($this->onlineMap[$id_user] != null);
    }

    /*
     * Данные одного пользователя
     */

    public function getOneUser($user_id)
    {
        //Выбираем данные пользователя
        if (empty($user_id)) {
            return $result = [];
        }
        $usersList = $this->msql->Select("SELECT * FROM users WHERE user_id = '$user_id'");

        //устанавливаем название роли
        $name_role = $this->msql->Select("SELECT role_name FROM roles WHERE role_id = {$usersList[0]['role_id']}");
        $result = $usersList;
        //вычисляем поле чекбокса
        if ($usersList[0]['user_status'] != 0) {
            $result[0]['checked'] = 'checked';
        } else {
            $result[0]['checked'] = '';
        }
        //Устанавливаем название поля role_name
        $result[0]['name_role'] = $name_role[0]['role_name'];

        return $result[0];
    }

    //Получаем всех пользователей
    public function getUsers()
    {
        $result = [];

        $usersList = $this->msql->Select("SELECT * FROM users");

        foreach ($usersList as $key => $value) {
            //устанавливаем название роли
            $name_role = $this->msql->Select("SELECT role_name FROM roles WHERE role_id = {$value['role_id']}");

            //вычисляем поле чекбокса
            if ($value['user_status'] != 0) {
                $result[$key] = $value;
                $result[$key]['checked'] = 'checked';
            } else {
                $result[$key] = $value;
                $result[$key]['checked'] = '';
            }
            if (!empty($name_role)) {
                $result[$key]['name_role'] = $name_role[0]['role_name'];
            }
        }

        return $result;
    }

    /*
     * Вносим в базу нового пользователя
     */

    public function createUser($name, $email, $password, $role, $status, $avatar)
    {
        $object = ['password' => $this->mFunctions->Clean($password),
            'user_email' => $this->mFunctions->Clean($email),
            'user_name' => $this->mFunctions->Clean($name),
            'role_id' => $this->mFunctions->Clean($role),
            'user_avatar' => $avatar,
            'user_status' => $this->mFunctions->Clean($status),
            'user_date_register' => date("Y-m-d H:i:s")];

        return $this->msql->Insert('users', $object);
    }

    /*
     * Обновляем данные пользователя
     */

    public function UpdateUser($email, $pass, $role, $user_id)
    {
        $new_pass = null;

        //Проверяем пароль
        $base_pass = $this->msql->Select("SELECT * FROM users WHERE user_id = '$user_id'");

        if ($pass == null) {
            $new_pass = $base_pass[0]['password'];
        } else {
            $new_pass = md5($pass);
        }
        //Проверяем роль
        if ($role == null) {
            $new_role = $base_pass[0]['role_id'];
        } else {
            $new_role = $role;
        }
        //Проверяем емеил
        if ($email == null) {
            $new_email = $base_pass[0]['user_email'];
        } else {
            $new_email = $email;
        }

        $object = ['user_email' => $this->mFunctions->Clean($new_email),
            'password' => $new_pass,
            'role_id' => $new_role,
            'user_time_update' => date("Y-m-d H:i:s")];

        $where = "user_id = $user_id";

        return $this->msql->Update('users', $object, $where);
    }

    //Создаем связь роли и привелегии

    public function checkRelationPrivToRole($role, $priv)
    {
        $premissions = [];
        $roles_s = [];
        $find_exist_relation = [];

        //Выбираем все роли
        $roles[] = $this->msql->Select("SELECT roles.role_id FROM roles");

        foreach ($roles as $key => $value) {
            foreach ($value as $keys => $values) {
                $roles_s[] = $values;
            }
        }
        //выбираем все привелегии
        foreach ($roles_s as $keyss => $valuess) {
            $premissions[$valuess['role_id']] = $this->getPermissionsByRole($valuess['role_id']);
        }

        foreach ($premissions as $key1 => $value1) {
            foreach ($value1 as $key2) {
                if ($key1 == $role && $key2['priv_id'] == $priv) {
                    return false;
                }
                //Находим роль у которой уже существует привязка к данной привелегии
                if ($key2['priv_id'] == $priv) {
                    $find_exist_relation[] = $this->msql->Select("SELECT * FROM privs2roles WHERE role_id = '$key1' AND priv_id = '$priv'");
                }
            }
        }
        if (empty($find_exist_relation)) {
            return false;
        }
        return $find_exist_relation[0];

    }

    /*
     * Все привелегии пользователя
     */

    public function getAllPrivsCurrentUser($role_id)
    {
        $result = [];
        $privs = $this->getPermissionsByRole($role_id);
        foreach ($privs as $key => $value) {
            $result[] = $value['name'];
        }
        return $result;
    }

    /*
     * Назначаем статус пользователя
     */

    public function setStatus($id, $status)
    {
        $cond = 0;

        if ($status == 'true') {
            $cond = 1;
        }
        if ($status == 'false') {
            $cond = 0;
        }
        $where = "user_id = " . $id;

        return $this->msql->Update('users', ['user_status' => $cond], $where);
    }

    /*
     * Выбираем все роли
     */

    public function getListRoles()
    {
        $query = "SELECT * FROM roles";

        return $this->msql->Select($query);
    }

    /*
     * выбираем роли и привелегии
     */

    public function getPrivsAndRoles()
    {
        $result = [];

        $query = "SELECT *  FROM roles,privs,privs2roles WHERE roles.role_id = privs2roles.role_id AND privs.priv_id = privs2roles.priv_id";

        $list = $this->msql->Select($query);

        $result[] = $list;

        return $result;
    }

    /*
     * Создаем роль
     */

    public function createRole($name, $description)
    {
        if (!empty($name) && !empty($description)) {

            $name = $this->mFunctions->Clean($name);
            $description = $this->mFunctions->Clean($description);

            return $this->msql->Insert('roles', ['role_name' => $name, 'description' => $description]);
        }
        return false;
    }

    /*
     * Создаем запись новой роли в таблице "auth_item_child"
     * Автоматически присваиваем потомком последней роли.
     */
    public function createNewRoleRelationParentChild()
    {
        //Выбираем самого последнего помка из таблицы auth_item_child базы данных
        $lastChildren = $this->msql->Select("SELECT MAX(child) AS lastChild FROM auth_item_child");

        //Выбираем новую роль из БД
        $newRole = $this->msql->Select("SELECT MAX(role_id) AS lastRole FROM roles");

        //Назначаем его родителем для новой роли
        $parent = $lastChildren[0]['lastChild'];
        $child = $newRole[0]['lastRole'];

        $result = $this->msql->Insert('auth_item_child', ['parent' => $parent, 'child' => $child]);

        return $result;
    }

    /*
     *  Удаляем связь parent child
     */

    public function deleteRelationParentChild($id_role)
    {
        if (!empty($id_role)) {
            $result = $this->msql->Delete('auth_item_child', "child = $id_role");
            return $result;
        }
        return false;
    }

    /*
     * Удаляем роль
     */

    public function deleteRole($role_id)
    {
        if (!empty($role_id)) {
            return $this->msql->Delete('roles', "role_id = $role_id");
        }
        return false;
    }

    /*
     * Получаем роль пользователя
     */

    public function getOneUserRole($user_id)
    {
        if (!empty($user_id)) {
            $query = "SELECT roles.role_name,roles.role_id FROM roles,users WHERE users.user_id = $user_id AND users.role_id = roles.role_id";
            return $this->msql->Select($query);
        }
        return false;
    }

    /*
     * Назначаем Роль привелегии
     */

    public function setRoleToPriv($priv, $role)
    {
        if (!empty($priv) && !empty($role)) {
            return $this->msql->Update('privs2roles', ['role_id' => $role], "priv_id = $priv");
        }
        return false;
    }

    /*
     * получаем роль пользователя
     */

    public function getOneRole($role_id)
    {
        if (!empty($role_id)) {
            return $this->msql->Select("SELECT * FROM roles WHERE role_id = '$role_id'");
        }
        return false;
    }

    /*
     * Обновляем роль
     */

    public function updateRole($name, $description, $role_id)
    {

        if (!empty($name) && !empty($description)) {

            $name = $this->mFunctions->Clean($name);
            $description = $this->mFunctions->Clean($description);

            $origin_role = $this->msql->Select("SELECT * FROM roles WHERE role_id = '$role_id'");

            if ($name != $origin_role[0]['role_name']) {
                $this->msql->Update('roles', ['role_name' => $name], "role_id = $role_id");
            }

            if ($description != $origin_role[0]['description']) {
                $this->msql->Update('roles', ['description' => $description], "role_id = $role_id");
            }
            return true;
        }
        return false;
    }

    /*
     * Добавить дочернюю роль
     */

    public function setSessionUserId($value)
    {
        return $_SESSION['user_id_f'] = $value;
    }

    /*
     *
     */

    public function getSessionUserId()
    {
        return $_SESSION['user_id_f'];
    }

    /*
     *
     */

    public function updateItem($table, $obj, $where)
    {
        if (!empty($table) && !empty($obj) && !empty($where)) {
            return $this->msql->Update($table, $obj, $where);
        }
        return false;
    }

    /*
     *
     */

    protected function addChild($parent, $child)
    {
        if ($parent === $child) {
            throw new Exception("Cannot add '{$parent}' as a child of itself.");
        }
        $this->msql->Insert('auth_item_child', ['parent' => $parent, 'child' => $child]);

        return true;
    }
    /*
     * Удаляем пользователя
     */
    public function deleteUser($user_id)
    {
        if (!empty($user_id)){
            //Выбираем фото загруженные пользователем
            $fotos = $this->msql->Select("SELECT name_image FROM images WHERE user_id = $user_id");
            //Пути к файлам
            $dirPath1 = BASEPATH . '/v/files/user_avatar/originals/';
            $dirPath2 = BASEPATH . '/v/files/user_avatar/resized/100/';
            //Перебираем их в цикле
            foreach ($fotos as $foto){
                //удаляем файлы
                if (file_exists($dirPath1.$foto['name_image'])) {
                    unlink($dirPath1.$foto['name_image']);
                }
                if (file_exists($dirPath2.$foto['name_image'])) {
                    unlink($dirPath2.$foto['name_image']);
                }
            }
            //Удаляем пользователя
            $this->msql->Delete('users', "user_id = '$user_id'");
        }
        return false;
    }

    /*
     * Все Фото пользователя
     */
    public function getUserImages($user_id)
    {
        if (!empty($user_id)) {

            $result = [];
            //Выбираем фото загруженные пользователем
            $fotos = $this->msql->Select("SELECT * FROM images WHERE user_id = $user_id ORDER BY user_id DESC");
            //если запрос вернул ноль то отправляем
            if (empty($fotos)) {
                $result ='Немає завантажених фото.';
            }
            //Перебираем их в цикле
            foreach ($fotos as $foto) {
                $result[] = $foto;
            }
            return $result;
        }
        return false;
    }

    /*
     *
     */

    public function deleteItem($table,$where){
        if (!empty($table)) {
            return $this->msql->Delete($table,$where);
        }
        return false;
    }
}

