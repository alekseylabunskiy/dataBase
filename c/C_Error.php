<?php

/**
 * Обработка ошибок
 */
class C_Error extends C_Base
{
    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();
    }


    protected function OnOutput()
    {
        $vars = [];

        $this->content = $this->View('404.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}