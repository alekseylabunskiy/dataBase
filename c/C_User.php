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
class C_User extends C_SiteController
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

        //Передаваемые данные в шаблон
        $vars = ['list_users' => $this->list,
            'permissions' => $this->permissions,];

        //Вывод на страницу
        $this->render('user/index.php', $vars);
    }

    /*
     * Меняем статус пользователя
     */
    public function actionStatus()
    {
        $status = [];
        //меняем статус пользователя ajax запросом
        if ($this->ajax == true) {
            if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {
                $stat = $this->mUser->setStatus($_POST['id'], $_POST['condition']);

                $status['change'] = $stat;
            }

            $this->setUpView('/ajax/tpl_json_data.php', ['json' => $status]);
        }
    }

    /*
     * Удаляем пользователя
     */
    public function actionDeleteUser()
    {
        //Удаляем пользователя, и им загруженные фото. (удаление фото настроено только из двух папок, /originals/ и /resized/100).
        //При появлении других папок с изображениями настроить пути удаления в функции deleteUser($id).

        if (isset($_GET['delete_id'])) {

            $id = $_GET['delete_id'];

            $this->mUser->deleteUser($id);

            $this->mFunctions->Redirect(['c' => 'user','a' => 'index']);
        }
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
            $this->mFunctions->Redirect(['c' => 'user','a' => 'view','id' => $user_id]);

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
            $r = $this->setUpView('/ajax/tpl_new_role.php', ['stat' => $json]);
            echo $r;
            die();
        }

        //Вывод на страницу
        $this->render('user/_one_user.php', $vars);
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

            $this->mFunctions->Redirect(['c' => 'main','a' => 'index']);
        }
        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($user_id);

        $vars = ['one_person' => $this->one_person];

        //Вывод на страницу
        $this->render('user/_view.php', $vars);
    }

    /*
     * Добавляем пользователя
     */
    public function actionAddUser()
    {
        $u_image = '';
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
            $this->mFunctions->Redirect(['c' => 'user','a' => 'view','id' => $u_id]);

        }

        //Вывод на страницу
        $vars = [];
        $this->render('user/_add_user.php', $vars);
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
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id =' . $user_id);
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

            $this->mUser->deleteItem('images', "name_image = '$name_foto'");

            $this->mImage->deleteSelectedImage($name_foto);
        }
        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($_POST['n_user_email'], $_POST['n_user_pass'], $_POST['new_role_user'], $user_id);

            $this->mFunctions->Redirect(['a' => 'user','c' => 'view','id' => '$user_id']);
        }

        //пользователь кабинета
        $this->one_person = $this->mUser->getOneUser($this->user['user_id']);

        //фото пользователя
        $this->user_images = $this->mUser->getUserImages($user_id);

        $vars = ['one_person' => $this->one_person, 'user_images' => $this->user_images];

        if (isset($_POST['deletedImageName'])) {
            $r = $this->render('/ajax/tpl_new_table_old_imgs.php', $vars);
            echo $r;
            die();
        }

        if ($this->ajax == true) {
            $r = $this->setUpView('/ajax/tpl_new_role.php', ['stat' => $this->json]);
            echo $r;
            die();
        }

        //Вывод на страницу
        $this->render('user/_kabinet.php', $vars);
    }
}
