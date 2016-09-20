<?php

/**
 * Обработчик ошибок
 **/
class M_Errors
{
    private static $instance;

    public static function Instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_Errors();
        }
        return self::$instance;
    }

    //Нет прав на просмотр этой страницы
    public function wrongAuthorization()
    {
        return $text = 'Ви не маєте прав доступу до цієї сторінки';
    }

    //Введен неверный URL
    public function wrongUrl()
    {
        return $text = '404. Такої сторінки не їснує!';
    }
}