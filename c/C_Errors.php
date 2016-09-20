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
        $text = $this->mErrors->wrongAuthorization();
        $vars = ['text' => $text];
        $this->content = $this->render('errors/404.php', $vars);
        parent::Out();
    }

    public function actionWrongUrl()
    {
        $text = $this->mErrors->wrongUrl();
        $vars = ['text' => $text];
        $this->content = $this->render('errors/404.php', $vars);
        parent::Out();
    }
}