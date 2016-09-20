<?php

/*
 *  Базовый контроллер сайта
 */

/**
 * @property array list
 * @property array roles
 * @property array|bool oneRole
 * @property array one_person
 * @property array|bool|string user_images
 * @property mixed|string name
 * @property mixed|string email
 * @property string password
 * @property bool|mysqli_result delete_result
 * @property array privsAndRoles
 * @property string json
 */
class C_Main extends C_SiteController
{
    private $name_foto;

    function __construct()
    {
        parent::__construct();
    }

    /**
     *  Главная страница, список пользователей
     */
    public function actionIndex()
    {
        //список всех пользователей
        $this->list = $this->mUser->getUsers();

        //меняем статус пользователя ajax запросом
        if ($this->ajax == true) {
            if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {
                $this->mUser->setStatus($_POST['id'], $_POST['condition']);
            }
        }

        //Удаляем пользователя, и им загруженные фото. (удаление фото настроено только из двух папок, /originals/ и /resized/100).
        //При появлении других папок с изображениями настроить пути удаления в функции deleteUser($id).

        if (isset($_GET['delete_id'])) {

            $id = $_GET['delete_id'];

            $this->mUser->deleteUser($id);

            header('Location:index.php?c=main&a=index');
        }

        //Передаваемые данные в шаблон
        $vars = ['list_users' => $this->list,
            'permissions' => $this->permissions,];

        //logout
        if (isset($_GET['logout'])) {
            $this->mUser->Logout();
            header("Location: index.php?c=main&a=login");
        }

        //Вывод на страницу
        $this->content = $this->render('main/index.php', $vars);
        parent::Out();
    }

    /**
     *  Страница логина
     */
    public function actionLogin()
    {
        //Логинимся
        if (isset($_POST['send'])) {
            if ($this->mUser->Login($_POST['u_mail'], $_POST['u_password'])) {
                header('Location: index.php?c=main&a=index');
            }
        }

        $vars = [];
        $this->content = $this->render('main/_login.php', $vars);
        parent::Out();
    }

    /**
     * Управление одной записью пользователя
     */
    public function actionSingleUser()
    {
        $user_id = '';
        $json = '';

        if (isset($_GET['id'])) {

            $user_id = $_GET['id'];

            $this->mUser->setSessionUserId($_GET['id']);
        }
        // Меняем фото при выборе ее из архива
        if (isset($_GET['image_id'])) {
            $id = $_GET['image_id'];
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id =' . $user_id);
        }
        //загружаем файлы
        if ($this->ajax == true) {

            if (!isset($_POST['addSelectedFoto']) && empty($_FILES) && !isset($_POST['deletedImageName'])) {
                $json = 'Виберіть файл!';
            }
            if (isset($_POST)) {

                $sizes = array(
                    '100' => ['width' => 100, 'height' => 100],
                );

                foreach ($_FILES as $file) {
                    //Создаем новое имя файла
                    $this->name_foto = $this->mImage->setNewNameFile();

                    $this->mImage->setSessionFoto($this->name_foto);

                    if (!isset($SESSION['name_foto']) || empty($SESSION['name_foto'])) {
                        $SESSION['name_foto'] = $this->name_foto;
                    }

                    //Проверяем на ошибки. Если нет то сохраняем изображение, а так, выводим ошибку
                    $errors = $this->mImage->checkImage();

                    if (empty($errors) && !empty($this->name_foto)) {

                        //Сохраняем имя изображения в базу
                        $this->mImage->saveTodB($SESSION['name_foto'], $this->user['user_id']);

                        //Сохраняем изображение на сервер
                        $this->mImage->SaveResized($sizes, $this->name_foto);

                        //Вытаскиваем только что добавленное изображение
                        $foto = $this->mImage->selectNewFoto($this->name_foto);
                        //Передаем имя изображения
                        $json['name_image'] = $foto[0]['name_image'];
                        //Очищаем массив $_FILES
                        $_FILES = null;
                        $_POST = null;
                    } else {
                        $json = $errors;
                    }
                }
                //Присваиваем новое фото пользователю
                if (isset($_POST['addSelectedFoto'])) {

                    //Достаем имя фотографии
                    $name_f = $this->mImage->getSessionFoto();

                    //Ай ди пользователя
                    $user_id_f = $this->mUser->getSessionUserId();

                    $json['name_new_image'] = $name_f;

                    $this->mImage->addImageToUser($user_id_f, $name_f);

                    //Обновляем дату редактирования
                    $this->mUser->updateItem('users', ['user_time_update' => date("Y-m-d H:i:s")], "user_id=" . $user_id_f);
                }
            }
        }
        //Удаляем одно изображение
        if (isset($_POST['deletedImageName'])) {
            $name_foto = $_POST['deletedImageName'][0];
            $name_foto = trim($name_foto);

            $this->mUser->deleteItem('images', "name_image = '$name_foto'");

            $this->mImage->deleteSelectedImage($name_foto);
        }
        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($_POST['n_user_email'], $_POST['n_user_pass'], $_POST['new_role_user'], $user_id);

            header("Location: index.php?c=main&a=view&id=$user_id");
        }
        //Все роли
        $this->roles = $this->mUser->getListRoles();

        //Роль пользователя
        $this->oneRole = $this->mUser->getOneUserRole($user_id);

        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($user_id);

        //фото пользователя
        $this->user_images = $this->mUser->getUserImages($user_id);

        $vars = ['one_person' => $this->one_person,
            'permissions' => $this->permissions,
            'oneRole' => $this->oneRole,
            'roles' => $this->roles,
            'stat' => $json,
            'user_images' => $this->user_images];

        if (isset($_POST['deletedImageName'])) {
            $r = $this->render('/ajax/tpl_new_table_old_imgs.php', $vars);
            echo $r;
            die();
        }

        if ($this->ajax == true) {
            $r = $this->render('/ajax/tpl_new_role.php', ['stat' => $json]);
            echo $r;
            die();
        }

        $this->content = $this->render('main/_one_user.php', $vars);
        parent::Out();
    }

    /*
     * Просмотр данных пользователя
     */
    public function actionView()
    {
        $user_id = $_GET['id'];

        //Удаляем пользователя
        if (isset($_GET['delete_id'])) {
            $this->mysqli->Delete('users', "user_id = {$_GET['delete_id']}");
            header('Location:index.php?c=main_list');
        }
        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($user_id);

        $vars = ['one_person' => $this->one_person];

        $this->content = $this->render('main/_view.php', $vars);
        parent::Out();
    }
    /*
     * Добавляем пользователя
     */
    public function actionAddUser()
    {
        $u_image = '';
        //Проверяем права доступа к данной странице
        if (!in_array('CAN_REDACT_USERS', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=errors&a=wrong_authorization');
        }
        //создаем пользователя
        if (isset($_POST['create_user'])) {

            $this->name = $this->mFunctions->Clean($_POST['new_user_name']);
            $this->email = $this->mFunctions->Clean($_POST['new_user_email']);
            $this->password = md5($_POST['new_user_password']);

            //Если изображение не загружено, устанавливаем его поумолчанию
            if (isset($_FILES['file_name']) && $_FILES['file_name']['name'] == '') {
                $u_image = 'avatar.png';
            }
            if (isset($_FILES['file_name']) && $_FILES['file_name']['name'] != '') {
                //Создаем новое имя файла
                $u_image = $this->mImage->setNewNameFile();
            }

            //Задаем размеры миниатюры
            $sizes = ['100' => ['width' => 100, 'height' => 100]];

            //Сохраняем изображение на сервер
            $this->mImage->SaveResized($sizes, $u_image);

            //Создаем пользователя
            $this->mUser->createUser($this->name, $this->email, $this->password, 4, 1, $u_image);

            //выбираем id новго пользователя
            $id = $this->mysqli->Select("SELECT MAX(users.user_id) AS user_id FROM users");

            //передаем на страницу просмотра профиля
            $u_id = $id[0]['user_id'];

            //Если передано изображение сохраняем его в базу изображений
            if ($u_image != 'avatar.png') {
                $this->mImage->saveTodB($u_image, $u_id);
            }
            //Перенапрвляем на страницу просмотра профиля
            header("location:index.php?c=main&a=view&id=$u_id");
        }
        $vars = [];

        $this->content = $this->render('main/_add_user.php', $vars);
        parent::Out();
    }
    /*
     * Управление Ролями
     */
    public function actionRoles()
    {
        $del_message = '';

        //Проверяем права доступа к данной странице
        if (!in_array('CAN_REDACT_ROLES', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=errors&a=wrong_authorization');
        }

        //Удаляем Роль
        if ($this->ajax == true) {
            if (isset($_POST['iddel'])) {
                //Удаляем роль
                $this->delete_result = $this->mUser->deleteRole($_POST['iddel'][0]);

                if (isset($this->delete_result)) {
                    if ($this->delete_result == false) {
                        $del_message['text'] = 'Ви не можете видалити цю роль так як вона має привелегії та користувачів';
                    }
                    if ($this->delete_result == true) {
                        //Удаляем связь в таблице parent child
                        $this->mUser->deleteRelationParentChild($_POST['iddel'][0]);
                    }
                }

            }
        }
        //Все роли
        $listRoles = $this->mUser->getListRoles();

        $vars = ['listRoles' => $listRoles,
            'del_message' => $del_message];

        if ($this->ajax == true) {
            if ($this->delete_result == false) {
                $r = $this->render('/ajax/tpl_new_role_table.php', ['del_message' => $del_message]);
                echo $r;
                die();
            }
            if ($this->delete_result == true) {
                $r = $this->render('/ajax/tpl_new_roles_list.php', $vars);
                echo $r;
                die();
            }
        }

        $this->content = $this->render('main/_roles.php', $vars);
        parent::Out();
    }

    /*
     * Создаем роль
     */
    public function actionCreateRole()
    {
        //Добавляем роль
        if (isset($_POST['create_new_role'])) {

            $this->mUser->createRole($_POST['name_new_role'], $_POST['description_new_role']);

            //Создаем связь в Parent Child для новой роли. по умолчанию делаем ее потомком самой младшей роли

            if (!empty($_POST['name_new_role'] && !empty($_POST['description_new_role']))) {
                $this->mUser->createNewRoleRelationParentChild();
            }
            header('location:index.php?c=main&a=roles');
        }

        $vars = [];
        $this->content = $this->render('main/_create_role.php', $vars);
        parent::Out();
    }

    /*
     * Редактируем роль
     */
    public function actionRedactRole()
    {
        //Обновляем роль
        if (isset($_POST['update_role'])) {
            $this->mUser->updateRole($_POST['name_role'], $_POST['description_role'], $_GET['role_id']);
            header('location:index.php?c=main&a=roles');
        }

        //Одна роль
        if (isset($_GET['role_id'])) {
            $this->oneRole = $this->mUser->getOneRole($_GET['role_id']);
        }

        $vars = ['oneRole' => $this->oneRole[0]];
        $this->content = $this->render('main/_redact_role.php', $vars);
        parent::Out();
    }

    /*
     * Управление привелегиями
     */
    public function actionPrivs()
    {
        //Проверяем права доступа к данной странице
        if (!in_array('CAN_REDACT_PRIVS', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=errors&a=wrong_authorization');
        }

        $stat = [];
        //Изменяем роль
        if (isset($_GET['id_role'])) {
            $this->mUser->changeRolePremission($_GET['id_role'], $_GET['priv_id']);
        }

        //Роли
        $this->roles = $this->mUser->getListRoles();

        //Роли и привелегии
        $this->privsAndRoles = $this->mUser->getPrivsAndRoles();

        //Меняем роль у привелегии
        if ($this->ajax == true) {

            if (isset($_POST['priv']) && !empty($_POST['priv']) && isset($_POST['role']) && !empty($_POST['role'])) {

                $set = $this->mUser->setRoleToPriv($_POST['priv'][0], $_POST['role'][0]);
                if ($set) {
                    $stat['status'] = 'ok';
                } else {
                    $stat['status'] = 'Error';
                }
            }
        }
        $vars = ['privsAndRoles' => $this->privsAndRoles[0],
            'roles' => $this->roles];

        if ($this->ajax == true) {
            $r = $this->render('/ajax/tpl_new_role.php', ['stat' => $stat]);
            echo $r;
            die();
        }

        $this->content = $this->render('main/_privs.php', $vars);
        parent::Out();
    }

    /*
     * Кабинет
     */
    public function actionKabinet()
    {
        $user_id = '';

        if (isset($this->user)) {
            $user_id = $this->user['user_id'];

            $this->mUser->setSessionUserId($this->user['user_id']);
        }

        // Меняем фото при выборе ее из архива
        if (isset($_GET['image_id'])) {
            $id = $_GET['image_id'];
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id ='.$user_id);
        }
        //загружаем файлы
        if ($this->ajax == true) {
            if (isset($_POST)) {

                if (!isset($_POST['addSelectedFoto']) && empty($_FILES) && !isset($_POST['deletedImageName'])) {
                    $this->json = 'Виберіть файл!';
                }

                $sizes = array(
                    '100' => array('width' => 100, 'heigth' => 100),
                );

                foreach ($_FILES as $files) {

                    $this->name_foto = $this->mImage->setNewNameFile();

                    $this->mImage->setSessionFoto($this->name_foto);

                    if (!isset($SESSION['name_foto']) || empty($SESSION['name_foto'])) {
                        $SESSION['name_foto'] = $this->name_foto;
                    }

                    //Проверяем на ошибки. Если нет то сохраняем изображение, а так, выводим ошибку
                    $errors = $this->mImage->checkImage();

                    if (empty($errors) && !empty($this->name_foto)) {

                        //Сохраняем имя изображения в базу
                        $this->mImage->saveTodB($SESSION['name_foto'], $this->user['user_id']);

                        //Сохраняем изображение на сервер
                        $this->mImage->SaveResized($sizes, $this->name_foto);

                        //Вытаскиваем только что добавленное изображение
                        $foto = $this->mImage->selectNewFoto($this->name_foto);
                        //Передаем имя изображения
                        $this->json['name_image'] = $foto[0]['name_image'];
                        //Очищаем массив $_FILES
                        $_FILES = null;
                        $_POST = null;
                    } else {
                        $this->json = $errors;
                    }
                }

                //Присваиваем новое фото пользователю
                if (isset($_POST['addSelectedFoto'])) {

                    //Достаем имя фотографии
                    $name_f = $this->mImage->getSessionFoto();

                    //Ай ди пользователя
                    $user_id_f = $this->mUser->getSessionUserId();

                    $this->json['name_new_image'] = $name_f;

                    $this->mImage->addImageToUser($user_id_f, $name_f);

                    //Обновляем дату редактирования
                    $this->mUser->updateItem('users', ['user_time_update' => date("Y-m-d H:i:s")], "user_id=" . $user_id_f);
                }
            }
        }

        //Удаляем одно изображение
        if (isset($_POST['deletedImageName'])) {
            $name_foto = $_POST['deletedImageName'][0];
            $name_foto = trim($name_foto);

            $this->mUser->deleteItem('images',"name_image = '$name_foto'");

            $this->mImage->deleteSelectedImage($name_foto);
        }
        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($_POST['n_user_email'], $_POST['n_user_pass'], $_POST['new_role_user'], $user_id);

            header("Location: index.php?c=view&id=$user_id");
        }

        //пользователь кабинета
        $this->one_person = $this->mUser->getOneUser($this->user['user_id']);

        //фото пользователя
        $this->user_images = $this->mUser->getUserImages($user_id);

        $vars = ['one_person' => $this->one_person,'user_images' => $this->user_images ];

        if (isset($_POST['deletedImageName'])) {
            $r = $this->render('/ajax/tpl_new_table_old_imgs.php',$vars);
            echo $r;
            die();
        }

        if ($this->ajax == true) {
            $r = $this->render('/ajax/tpl_new_role.php', ['stat' => $this->json]);
            echo $r;
            die();
        }

        $this->content = $this->render('main/_kabinet.php', $vars);
        parent::Out();
    }
}
