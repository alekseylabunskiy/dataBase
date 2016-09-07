<?php

/*
 *
 */

class C_Welcome extends C_Base
{
    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

        //если есть пользователь редирект на главную страницу
        if ($this->user != null){
            header('location:index.php?c=main_list');
        }
    }


    protected function OnOutput()
    {
        $vars = [];

        $this->content = $this->View('tpl_welcome.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}