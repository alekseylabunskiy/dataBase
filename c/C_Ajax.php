<?php

/**
 * Класс обработки Ajax запросов
 */
class C_Ajax extends C_Base
{
    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();
        //обновляем статус пользователя

        if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {
            $this->mUser->setStatus($_POST['id'], $_POST['condition']);
        }
    }


    protected function OnOutput()
    {
        $vars = [];

        $page = $this->View('tpl_ajax.php', $vars);

        echo $page;
    }
}