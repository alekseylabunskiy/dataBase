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
            header('Location:index.php?d=login&a=index');
        }
        //Логинимся
        if (isset($_POST['send'])) {
            if ($this->mUser->Login($_POST['u_mail'], $_POST['u_password'])) {
                header('Location: index.php?c=user&a=index');
            }
        }

        //Вывод на страницу
        $vars = [];
        $this->render('login/_login.php', $vars);
    }
}