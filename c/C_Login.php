<?php

/*
 * Отвечает за логин пользователя
 */

class C_Login extends C_Base
{
    private $login;

    public function __construct()
    {
        parent::__construct();
        $this->login = '';
    }

    protected function OnInput()
    {
        parent::OnInput();

        if ($this->user != null) {
            $this->mUser->Logout();
            header('location:index.php');
        }

        $this->mErrors->clearErrorSessions();

        if (isset($_POST['send'])) {
            if ($this->mUser->Login($_POST['u_mail'], $_POST['u_password'])) {
                header('Location: index.php?c=main_list');
                die();
            }
        }
        if (isset($_POST['u_mail'])) {
            $this->login = $_POST['u_mail'];
        }
    }

    protected function OnOutput()
    {
        $vars = ['login' => $this->login];
        $this->content = $this->View('tpl_login.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}