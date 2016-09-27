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

            $this->user_id = $this->user['user_id'];

        //Если редактируем пользователя передаем его ай ди
        if (isset($_GET['id'])) {
            $this->user_id  = $_GET['id'];
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
        //Отправляем обновленные данные пользователя
        if ($this->ajax == true) {
            $res = $this->mUser->UpdateUser($_POST['email'], $_POST['pass'], $_POST['role'], $_POST['id']);
            if ($this->ajax == true) {
                if ($res == true) {
                    echo json_encode('Данні успішно збережені.');
                    die();
                } else {
                    echo json_encode('Помилка! Данні не збережені!');
                    die();
                }

            }
        }

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
            if (!empty($_POST['condition']) && !empty($_POST['id'])) {

                $stat = $this->mUser->setStatus($_POST['id'], $_POST['condition']);

                if ($this->ajax == true) {
                    echo json_encode($stat);
                }
            }
        }
    }
    /*
     * Загружаем файлы
     */
    public function actionUploadImages()
    {
        if (isset($_GET['id_u'])) {
            $this->user_id = $_GET['id_u'];
        }
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
     * Обновляем изображение пользователя из архива
     */
    public function actionUpdateImage()
    {
        if (!empty($_GET['id_u'])) {
            $this->user_id = $_GET['id_u'];
        }
        // Меняем фото при выборе ее из архива
        if (isset($_GET['image_id'])) {
            $id = $_GET['image_id'];
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id =' . $this->user_id);

            $this->mFunctions->redirect(['c' => 'user', 'a' => 'update', 'id' => $this->user_id]);
        }

        $json = [];
        $json['id'] = $this->user_id;
        $json['name'] = $this->user_id;
        //Достаем имя фотографии
        $name_f = $this->mImage->getSessionFoto();

        $json['name_new_image'] = $name_f;

        if ($this->ajax == true) {
            $this->mImage->addImageToUser($this->user_id,$name_f);
        }

        unset($_SESSION['name_foto']);

        if ($this->ajax == true) {
            echo json_encode($json);
        }

    }

    /*
     * Удаляем одно изображение
     */
    public function actionDeleteImage()
    {
        if ($this->ajax == true) {
            $name_img = $_POST['deletedImageName'][0];
            $name_img = trim($name_img);
            //Удаляем запись в базе данных
            $this->mImage->deleteSelectedImage("$name_img");
           // $this->mUser->deleteItem('images',"name_image = '$name_img'");
        }
        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($this->user_id);

        //Все загруженные изображения пользователя
        $this->user_images = $this->mUser->getUserImages($this->user_id);

        $vars = ['one_person' => $this->one_person, 'user_images' => $this->user_images];

        $this->render('/ajax/tpl_new_table_old_imgs.php', $vars, true);

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
