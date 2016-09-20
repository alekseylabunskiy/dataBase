<?php

/**
 * Класс обработки ошибок
 */
class C_Errors extends C_SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionWrongAuthorization()
    {
        $vars = [];
        $this->content = $this->render('errors/404.php', $vars);
        parent::Out();
    }
}