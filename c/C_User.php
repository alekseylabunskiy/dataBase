<?php

/*
 *  Базовый контроллер сайта
 */

/**
 * @property array list
 * @property array role
 * @property array|bool oneRole
 * @property array one_person
 * @property array|bool|string user_images
 * @property mixed|string name
 * @property mixed|string email
 * @property string password
 * @property bool|mysqli_result delete_result
 * @property array privsAndRoles
 * @property string json
 * @property array roles
 */
class C_User extends C_SiteController
{
    protected $user_id;
    private $name_foto;

    function __construct()
    {
        parent::__construct();

        //Если польз. зашел в кабинет передаем его айди
        if (!isset($_GET['id'])) {
            $_SESSION['id'] = $this->user['user_id'];
            $this->user_id = $_SESSION['id'];
        }
        if (isset($_GET['id'])) {
            $_SESSION['id'] = $_GET['id'];
            $this->user_id = $_SESSION['id'];
        }
    }

    /**
     *  Главная страница, список пользователей
     */
    public function actionIndex()
    {
        //список всех пользователей
        $this->list = $this->mUser->getUsers();

        //Вывод на страницу
        return $this->render('user/index.php', ['list_users' => $this->list, 'permissions' => $this->permissions]);
    }

    /**crud
     * Управление одной записью пользователя
     */
    public function actionUpdate()
    {
        //Все роли
        $this->roles = $this->mUser->getListRoles();

        //Роль пользователя
        $this->oneRole = $this->mUser->getOneUserRole($this->user_id);

        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($this->user_id);

        //Все загруженные изображения пользователя
        $this->user_images = $this->mUser->getUserImages($this->user_id);

        $vars = ['one_person' => $this->one_person,
            'permissions' => $this->permissions,
            'oneRole' => $this->oneRole,
            'roles' => $this->roles,
            'user_images' => $this->user_images];

        //Вывод на страницу
        $this->render('user/update.php', $vars);
    }

    /*
     * Удаляем пользователя
     */
    public function actionDelete()
    {
        //Удаляем пользователя, и им загруженные фото. (удаление фото настроено только из двух папок, /originals/ и /resized/100).
        //При появлении других папок с изображениями настроить пути удаления в функции deleteUser($id).

        if (isset($_GET['delete_id'])) {

            $id = $_GET['delete_id'];

            $this->mUser->deleteUser($id);

            $this->mFunctions->redirect(['c' => 'user', 'a' => 'index']);
        }
    }
    /*
     * Просмотр данных пользователя
     */
    public function actionView()
    {
        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($_GET['id']);

        //Вывод на страницу
        return $this->render('user/view.php', ['one_person' => $this->one_person]);
    }

    /*
     * Меняем статус пользователя
     */
    public function actionStatus()
    {
        //меняем статус пользователя ajax запросом
        if ($this->ajax == true) {
            if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {

                $stat = $this->mUser->setStatus($_POST['id'], $_POST['condition']);

                if ($this->ajax == true) {
                    echo json_encode($stat);
                }
            }
        }
    }

    /*
     * Обновляем изображение пользователя из архива
     */
    public function actionUpdateFoto()
    {
        // Меняем фото при выборе ее из архива
        if (isset($_GET['image_id'])) {
            $id = $_GET['image_id'];
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id =' . $this->user_id);

            $this->mFunctions->redirect(['c' => 'user', 'a' => 'update', 'id' => $this->user_id]);
        }

    }

    /*
     * Обновляем данные пользователя
     */
    public function actionUpdateUser()
    {
        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($_POST['n_user_email'], $_POST['n_user_pass'], $_POST['new_role_user'], $this->user_id);

            $this->mFunctions->redirect(['c' => 'user', 'a' => 'view', 'id' => $this->user_id]);
        }
    }

    /*
     * Обновляем фото аватара после загрузки нового фото
     */
    public function actionChangeImage()
    {
        $json = [];
        //Достаем имя фотографии
        $name_f = $this->mImage->getSessionFoto();

            $id_user = $this->user_id;

            $json['name_new_image'] = $name_f;

        if ($this->ajax == true) {
            $this->mImage->addImageToUser($id_user,$name_f);
        }

        //Обновляем дату редактирования
        $this->mUser->updateItem('users', ['user_time_update' => date("Y-m-d H:i:s")], "this->user_id=" . $id_user);

        unset($_SESSION['name_foto']);
        unset($_SESSION['id']);

        if ($this->ajax == true) {
            echo json_encode($json);
        }
    }

    /*
     * Удаляем одно изображение
     */
    public function actionDeleteImage()
    {
        $name_img = $_POST['deletedImageName'][0];

        $this->mImage->deleteSelectedImage($name_img);

        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($this->user_id);

        //Все загруженные изображения пользователя
        $this->user_images = $this->mUser->getUserImages($this->user_id);

        $vars = ['one_person' => $this->one_person, 'user_images' => $this->user_images];

        return $this->render('/ajax/tpl_new_table_old_imgs.php', $vars, true);
    }

    /*
     * Загружаем файлы
     */
    public function actionUploadImages()
    {
        $json = '';

        $sizes = array(
            '100' => ['width' => 100, 'height' => 100],
        );

        if ($_FILES != null) {

            //Создаем новое имя файла
            $this->name_foto = $this->mImage->setNewNameFile();

            //Проверяем на ошибки. Если нет то сохраняем изображение, а так, выводим ошибку
            $errors = $this->mImage->checkImage();

            if (empty($errors) && !empty($this->name_foto)) {

                //Сохраняем имя изображения в базу

                $this->mImage->saveTodB($this->name_foto, $this->user_id);

                //Сохраняем изображение на сервер
                $this->mImage->SaveResized($sizes, $this->name_foto);

                //Вытаскиваем только что добавленное изображение
                $foto = $this->mImage->selectNewFoto($this->name_foto);
                //Передаем имя изображения
                $json['name_image'] = $foto[0]['name_image'];

                $_SESSION['name_foto'] = $json['name_image'];
            } else {
                $json = $errors;
            }
        }
        if ($this->ajax == true) {
            echo json_encode($json);
        }
        $_FILES = '';
    }

    /*
     * Добавляем пользователя
     */
    public function actionCreate()
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
            $this->mFunctions->redirect(['c' => 'user', 'a' => 'view', 'id' => $u_id]);

        }

        //Вывод на страницу
        $vars = [];
        $this->render('user/create.php', $vars);
    }
}
