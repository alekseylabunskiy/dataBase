<?php

/**
 * Создаем нового пользователя
 */
class C_AddUser extends C_Base
{
    protected $name;
    protected $password;
    protected $email;

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

            $this->mUser->createUser($this->name, $this->email, $this->password, 4, 1, 'avatar.png');
            //выбираем id новго пользователя
            $id = $this->mysqli->Select("SELECT MAX(users.user_id) AS user_id FROM users");
            //передаем на страницу просмотра профиля
            if (!isset($_GET['id'])) {
                $_GET['id'] = $id[0]['user_id'];
            }

            //Перенапрвляем на страницу просмотра профиля
            header("location:index.php?c=view&id={$_GET['id']}");
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