<?php

/*
 * Базовый класс
 */

abstract class C_Controller
{
    public $method;

    public function __construct()
    {
    }

    public function Request($method)
    {
        $this->$method();
    }

    protected function setUpView($template, $vars)
    {
        $page = $this->setView($template, $vars);

        echo $page;
    }

    protected function setView($fileName, $vars = [])
    {
        foreach ($vars as $k => $v) {
            $$k = $v;
        }
        ob_start();
        include "v/$fileName";
        return ob_get_clean();

    }
}
