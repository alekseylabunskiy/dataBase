<?php

/**
 * Создаем нового пользователя
 */
class C_AddUser extends C_Base
{
    protected $name;
    protected $password;
    protected $email;
    protected $u_image;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();
        if ($this->user == null && $this->needLogin == true) {
            header('location:index.php?c=login');
        }

        //создаем пользователя
        if (isset($_POST['create_user'])) {
            $this->name = $this->mFunctions->Clean($_POST['new_user_name']);
            $this->email = $this->mFunctions->Clean($_POST['new_user_email']);
            $this->password = md5($_POST['new_user_password']);

            //Если изображение не загружено, устанавливаем его поумолчанию
            if (isset($_FILES['file_name']) && $_FILES['file_name']['name'] == '') {
                $this->u_image = 'avatar.png';
            }
            if (isset($_FILES['file_name']) && $_FILES['file_name']['name'] != '') {
                //Создаем новое имя файла
                $this->u_image = $this->image->setNewNameFile();
            }

            //Задаем размеры миниатюры
            $sizes = array(
                '100' => ['width' => 100, 'heigth' => 100],
            );
            //Сохраняем изображение на сервер
            $this->image->SaveResized($sizes, $this->u_image);
            //Создаем пользователя
            $this->mUser->createUser($this->name, $this->email, $this->password, 4, 1, $this->u_image);

            //выбираем id новго пользователя
            $id = $this->mysqli->Select("SELECT MAX(users.user_id) AS user_id FROM users");

            //передаем на страницу просмотра профиля
            $u_id = $id[0]['user_id'];

            //Если передано изображение сохраняем его в базу изображений
            if ($this->image != 'avatar.png') {
                $this->image->saveTodB($this->u_image, $u_id);
            }
            //Перенапрвляем на страницу просмотра профиля
            header("location:index.php?c=view&id=$u_id");
        }
    }

    protected function OnOutput()
    {
        $vars = ['canRedactUsers' => $this->canRedactUsers];

        $this->content = $this->View('tpl_add_user.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}