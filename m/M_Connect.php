<?php

/*
 * Класс подключения к базе данных
 */

class M_Connect extends M_Config
{
    public function Connection()
    {
        $mysqli = new mysqli($this->host, $this->user, $this->password, $this->nameDB);

        if (mysqli_connect_errno()) {
            printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        return $mysqli;
    }
}