<?php

/**
 * Разные вспомогательные вункции
 */
class M_Functions
{
    private static $instance;
    //
    // Получение единственного экземпляра (одиночка)
    //

    public function __construct()
    {
        $this->mysqli = M_MSQL::Instance();
        $this->mErrors = M_Errors::Instance();
    }

    public static function Instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_Functions();
        }
        return self::$instance;
    }

    /*
     * Функция поучения контроллеров из параметра GET
     */
    public function getControllers($get)
    {
        $class_name = '';
        /*
         * В коде ниже гет параметр, если он составной разбивается на отдельные части, склеивается в название Контроллера.
         */
        if ($get != null) {
            if (strstr($get, '_')) {

                $parts = explode('_', $get);
                $first_1 = mb_substr($parts[0], 0, 1, 'UTF-8');//первая буква
                $last_1 = mb_substr($parts[0], 1);//все кроме первой буквы
                $first_1 = mb_strtoupper($first_1, 'UTF-8');
                $last_1 = mb_strtolower($last_1, 'UTF-8');
                $partOne = $first_1 . $last_1;

                $partTwo = $parts[1];
                $first = mb_substr($partTwo, 0, 1, 'UTF-8');//первая буква
                $last = mb_substr($partTwo, 1);//все кроме первой буквы
                $first = mb_strtoupper($first, 'UTF-8');
                $last = mb_strtolower($last, 'UTF-8');
                $partTwo = $first . $last;
                $class = 'C_' . $partOne . $partTwo;
                if ($this->getExistentControllers($class)) {
                    $class_name = new $class;
                }
            } else {
                $first = mb_substr($get, 0, 1, 'UTF-8');//первая буква
                $last = mb_substr($get, 1);//все кроме первой буквы
                $first = mb_strtoupper($first, 'UTF-8');
                $last = mb_strtolower($last, 'UTF-8');
                $gets = $first . $last;
                $class = 'C_' . $gets;
                if ($this->getExistentControllers($class)) {
                    $class_name = new $class;
                }
            }
        } else {
            $class_name = new C_Errors();
        }
        return $class_name;
    }

    public function getExistentControllers($name)
    {
        $dir = 'c';
        $files = scandir($dir);

        $name_controller = $name . ".php";

        foreach ($files as $file) {
            if ($file == $name_controller) {
                return true;
            }
        }
        return false;
    }

    /*
     * Функция проверки наличия контроллера
     */

    public function getMethod($c_method)
    {
        if (!empty($c_method)) {
            if (strstr($c_method, '_')) {

                $parts = explode('_', $c_method);
                $first_1 = mb_substr($parts[0], 0, 1, 'UTF-8');//первая буква
                $last_1 = mb_substr($parts[0], 1);//все кроме первой буквы
                $first_1 = mb_strtoupper($first_1, 'UTF-8');
                $last_1 = mb_strtolower($last_1, 'UTF-8');
                $partOne = $first_1 . $last_1;

                $partTwo = $parts[1];
                $first = mb_substr($partTwo, 0, 1, 'UTF-8');//первая буква
                $last = mb_substr($partTwo, 1);//все кроме первой буквы
                $first = mb_strtoupper($first, 'UTF-8');
                $last = mb_strtolower($last, 'UTF-8');
                $partTwo = $first . $last;
                $methods = $partOne . $partTwo;
            } else {
                $first = mb_substr($c_method, 0, 1, 'UTF-8');//первая буква
                $last = mb_substr($c_method, 1);//все кроме первой буквы
                $first = mb_strtoupper($first, 'UTF-8');
                $last = mb_strtolower($last, 'UTF-8');
                $methods = $first . $last;
            }
            return 'action' . $methods;
        }
        return 'actionIndex';
    }

    public function Clean($text)
    {
        $quotes = array("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!");
        $goodquotes = array("-", "+", "#");
        $repquotes = array("\-", "\+", "\#");
        $text = trim(strip_tags($text));
        $text = str_replace($quotes, '', $text);
        $text = str_replace($goodquotes, $repquotes, $text);
        $text = str_replace(" +", " ", $text);

        return $text;
    }

    /*
     * Проверка на AJAX запрос
     */
    public function getIsAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /*
     * Функция проверки прав доступа к страницам
     */
    public function getAccessToPage($user_permissions, $controller, $method)
    {
        if (!empty($user_permissions) && !empty($controller) && !empty($method)) {

            $controller = strtoupper($controller);
            $method = strtoupper($method);

            $inter = $controller.$method;

            $income = str_replace("_","",$inter);

            foreach ($user_permissions as $key => $value) {

                if (strstr($value,"_")) {

                    $parts = explode("_", $value);
                    $priv = implode('',$parts);

                    if ($priv == $income) {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    /*
     * Метод редиректа
     */

    public function redirect($params)
    {
        $get = [];
        $r = '';
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $r .= $key . "=" . $value . "&";
                $length = strlen($r);
                $get[0] = substr($r, 0, $length - 1);
            }
        }

        header("location:index.php?" . $get[0]);
        die();
    }
}
