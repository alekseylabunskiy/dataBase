<?php
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

date_default_timezone_set('Europe/Kiev');
//параметр get
$get = '';

function __autoload($classname)
{
    $type = explode('_', $classname);
    switch ($type[0]) {
        case 'C':
            include_once 'c/' . $classname . '.php';
            break;
        case 'M':
            include_once 'm/' . $classname . '.php';
            break;
    }
}

if (isset($_GET['c'])) {
    $get = $_GET['c'];
} else {
    $get = 'welcome';
}
//Подключаем контроллеры
$controllers = new M_Functions();

$controller = $controllers->getControllers($get);

// Обработка запроса.
$controller->Request();
