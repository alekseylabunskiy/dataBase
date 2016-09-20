<?php
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

date_default_timezone_set('Europe/Kiev');

define("BASEPATH", dirname(__FILE__).'/');

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

if (isset($_GET['c']) && isset($_GET['a'])) {
    $c_controller = $_GET['c'];
    $c_method = $_GET['a'];
} else {
    $c_controller = 'main';
    $c_method = 'login';
}
//Подключаем модель
$controllers = new M_Functions();
//Подключаем контроллеры
$controller = $controllers->getControllers($c_controller);
//Подключаем методы
$a_method = $controllers->getMethod($c_method);
// Обработка запроса.
$controller->Request($a_method);
