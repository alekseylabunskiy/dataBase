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
        $text = 'Ви не маєте прав доступу до цієї сторінки';
        if (!isset($_SESSION['wrong_auth'])) {
            return $_SESSION['wrong_auth'] = $text;
        }
    }

    //Введен неверный URL
    public function wrongUrl()
    {
        $text = 'код 404. Такої сторінки не їснує!';
        if (!isset($_SESSION['wrong_url'])) {
            return $_SESSION['wrong_url'] = $text;
        }
    }
    //Чистим сессии ошибок
    public function clearErrorSessions()
    {
        unset($_SESSION['wrong_auth']);
        unset($_SESSION['wrong_url']);
    }

}