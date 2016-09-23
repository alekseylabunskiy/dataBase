<?php

/**
 * Класс Логин
 */
class C_Login extends C_SiteController
{
    /**
     *  Страница логина
     */
    public function actionIndex()
    {
        //Разлогиниваемся
        if (!empty($this->user)) {
            $this->mUser->Logout();
            $this->mFunctions->Redirect(['c' => 'login','a' => 'index']);
        }
        //Логинимся
        if (isset($_POST['send'])) {
            if ($this->mUser->Login($_POST['u_mail'], $_POST['u_password'])) {
                $this->mFunctions->Redirect(['c' => 'user','a' => 'index']);
            }
        }

        //Вывод на страницу
        $vars = [];
        $this->render('login/_login.php', $vars);
    }
    /*
     * Logout
     */
    public function actionLogout()
    {
        if (isset($_GET['a']) && $_GET['a'] == 'logout') {
            $this->mUser->Logout();
            $this->mFunctions->Redirect(['c' => 'login', 'a' => 'index']);
        }
    }
}