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
            $this->mFunctions->redirect(['c' => 'login','a' => 'index']);
            die();
        }

        //Логинимся
        if (isset($_POST['send'])) {
            if ($this->mUser->Login($_POST['email'], $_POST['u_password'])) {
                $this->mFunctions->redirect(['c' => 'user','a' => 'index']);
            }
        }

        //Вывод на страницу
        $vars = [];
        $this->render('login/index.php', $vars);
    }
    /*
     * Logout
     */
    public function actionLogout()
    {
        $this->mUser->Logout();
        $this->mFunctions->redirect(['c' => 'login', 'a' => 'index']);

    }
}