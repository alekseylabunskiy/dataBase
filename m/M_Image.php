<?php

/*
 * Класс по работе с изображениями
 */

class M_Image
{

    private static $instance;
    public $image_type;
    public $image;
    protected $nameImage;

    public function __construct()
    {
        $this->msql = M_MSQL::Instance();

        foreach ($_FILES as $file) {
            $this->load($file['tmp_name']);
        }
    }

    public function load($filename)
    {
        if (!empty($filename)) {
            $image_info = getimagesize($filename);
            $this->image_type = $image_info[2];
            if ($this->image_type == IMAGETYPE_JPEG)
                $this->image = imagecreatefromjpeg($filename);
            elseif ($this->image_type == IMAGETYPE_GIF)
                $this->image = imagecreatefromgif($filename);
            elseif ($this->image_type == IMAGETYPE_PNG)
                $this->image = imagecreatefrompng($filename);
        }
        return false;
    }

    public static function Instance()
    {
        if (self::$instance == null) {
            self::$instance = new M_Image();
        }
        return self::$instance;
    }

    /*
     * Основная функция для работы с изображением
     */

    public function SaveResized($sizes, $name)
    {
        //Задаем пути для фото

        $pathToResize = BASEPATH . "/v/files/user_avatar/resized/";
        $pathToOriginal = BASEPATH . "/v/files/user_avatar/originals/";

        //Для сохранения оригинала оставляем пропорции фото
        $size = $this->scale(90);

        //Сохраняем оригинал
        foreach ($size as $key) {
            if (!empty($key)) {
                $width = $key['width'];
                $height = $key['height'];
                foreach ($_FILES as $file) {
                    $this->create_thumbnail($file['tmp_name'], $pathToOriginal . $name, $width, $height);
                }
            }
        }

        //Сохраняем миниатюру
        krsort($sizes);

        foreach ($sizes as $key => $value) {

            if (!empty($key)) {
                if (!file_exists($pathToResize . $key)) {
                    mkdir($pathToResize . $key);
                }
            }

            $width = $value['width'];
            $height = $value['heigth'];

            foreach ($_FILES as $file) {
                $this->create_thumbnail($file['tmp_name'], $pathToResize . $key . "/" . $name, $width, $height);
            }
        }
    }

    public function scale($scale)
    {
        $sizes = [];

        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;

        $sizes[0]['width'] = $width;
        $sizes[0]['height'] = $height;

        return $sizes;
    }

    public function getWidth()
    {
        return imagesx($this->image);
    }

    public function getHeight()
    {
        return imagesy($this->image);
    }

    function create_thumbnail($path, $save, $width, $height)
    {
        $info = getimagesize($path); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
        } else {
            return false;
        }

        $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
        $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
        $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

        if ($src_aspect > $thumb_aspect) {        //узкий вариант (фиксированная ширина)      $scale = $width / $size[0];         $new_size = array($width, $width / $src_aspect);        $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки   } else if ($src_aspect > $thumb_aspect) {
            //широкий вариант (фиксированная высота)
            $scale = $height / $size[1];
            $new_size = array($height * $src_aspect, $height);
            $src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
        } else {
            //другое
            $new_size = array($width, $height);
            $src_pos = array(0, 0);
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
        //Копирование и изменение размера изображения с ресемплированием

        if ($save === false) {
            return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
        } else {
            return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }

    }

    public function saveTodB($fileName, $user_id)
    {
        if (!empty($fileName) && !empty($user_id)) {
            return $this->msql->Insert('images', ['name_image' => $fileName, 'user_id' => $user_id, 'create_at' => date("Y-m-d H:i:s")]);
        }
        return false;
    }

    public function checkImage()
    {
        $errors = [];
        $tmp_error = [];
        $max_file_size = 1000000;
        foreach ($_FILES as $file) {
            $info = getimagesize($file['tmp_name']); //получаем размеры картинки и ее тип

            //Проверяем тип файла.
            if ($info['mime'] == 'image/png') {
                $tmp_error['error'][] = null;
            } else if ($info['mime'] == 'image/jpeg') {
                $tmp_error['error'][] = null;
            } else if ($info['mime'] == 'image/gif') {
                $tmp_error['error'][] = null;
            } else {
                $tmp_error['error'][] = 'Невідомий тип файлу.';
            }

            //Проверяем размер картинки в Мв
            ($file['size'] < $max_file_size) ? $tmp_error['error'][] = null : $tmp_error['error'][] = 'Файл має бути меньшим за 1 Мегабайт';

            ($file = '') ? $tmp_error['error'][] = 'Введіть ім\'я файлу' : $tmp_error['error'][] = null;
        }
        foreach ($tmp_error as $key => $value) {
            foreach ($value as $keys) {
                if ($keys != null) {
                    $errors[] = $keys;
                }
            }
        }
        return $errors;
    }

    /*
     * Функция выбора только что добавленного фото
     */
    public function selectNewFoto($name)
    {
        $res = [];

        if (!empty($name)) {
            $query = $this->msql->Select("SELECT * FROM images WHERE name_image = '$name'");
            $res[] = $query[0];

            return $res;
        }
        return false;
    }

    /*
     * Обновляем фото у пользователя
     */
    public function addImageToUser($user_id, $name_img)
    {
        if (!empty($user_id) && !empty($name_img)) {
            return $this->msql->Update('users', ['user_avatar' => $name_img], 'user_id=' . $user_id);
        }
        return false;
    }

    /*
     *
     */
    public function setSessionFoto($value)
    {
        return $_SESSION['name_foto'] = $value;
    }

    /*
     *
     */
    public function getSessionFoto()
    {
        return $_SESSION['name_foto'];
    }

    /*
     * Новое имя изображения
     */
    public function setNewNameFile()
    {
        if (!empty($_FILES)) {
            $new_name = '';
            foreach ($_FILES as $file) {
                preg_match('/\.(jpg|jpeg|gif|jpe|png|pcx|bmp)$/i', $file['name'], $matches);

                $un = uniqid("");
                $rand = md5(md5(rand(1, 5000) + rand(1, 10000)));
                $new_name = $un . $rand . $matches[0];
            }
            return $new_name;
        }
        return false;
    }

    /*
     * Удаляем одно изображение
     */
    public function deleteSelectedImage($image_name)
    {
        if (!empty($image_name)) {
            //Удаляем запись в базе данных
            $result = $this->msql->Delete('images', "name_image = $image_name");
            //Пути к файлам
            $dirPath1 = BASEPATH . '/v/files/user_avatar/originals/';
            $dirPath2 = BASEPATH . '/v/files/user_avatar/resized/100/';
            //Перебираем их в цикле
            //удаляем файлы
            if (file_exists($dirPath1 . $image_name)) {
                unlink($dirPath1 . $image_name);
            }
            if (file_exists($dirPath2 . $image_name)) {
                unlink($dirPath2 . $image_name);
            }
            return $result;
        }
        return false;
    }

    /*
     * Проверка существования файлов изображения пользователя
     */

    public function removeReferencesToNonexistentImage()
    {
        //Проверка существования изображений
        $this->removeReferencesToAllNonexistentImages();

        $result = '';

        //Выбераем все изображения пользователей
        $usersImages = $this->msql->Select("SELECT users.user_avatar, users.user_id FROM users");

        if (!empty($usersImages)) {
            foreach ($usersImages as $image) {
                //Пути к файлам
                $dirPath1 = BASEPATH . '/v/files/user_avatar/originals/';
                $dirPath2 = BASEPATH . '/v/files/user_avatar/resized/100/';
                //Перебираем их в цикле
                //если такого файла нет то ставим заглушку вместо фото
                if (!file_exists($dirPath1 . $image['user_avatar']) || !file_exists($dirPath2 . $image['user_avatar'])) {
                    $result = $this->msql->Update('users', ['user_avatar' => 'avatar.png'], 'user_id=' . $image['user_id']);
                }
            }
            return $result;
        }
        return false;
    }

    /*
     * Провека на существование фото, и если ыото нет удаляется ссылка на это изображение
     */

    protected function removeReferencesToAllNonexistentImages()
    {
        $result = '';
        //Выбераем все изображения пользователей
        $usersImages = $this->msql->Select("SELECT name_image FROM images");

        if (!empty($usersImages)) {
            foreach ($usersImages as $image) {
                foreach ($image as $item) {
                    $name = $item;
                    //Пути к файлам
                    $dirPath1 = BASEPATH . 'v/files/user_avatar/originals/';
                    $dirPath2 = BASEPATH . 'v/files/user_avatar/resized/100/';

                    //Перебираем их в цикле
                    //если такого файла нет то удаляем пустую ссылку
                    if (!file_exists($dirPath1 . $name) || !file_exists($dirPath2 . $name)) {
                        $result = $this->msql->Delete('images',"name_image = '$name'");
                    }
                }
            }
            return $result;
        }
        return false;
    }
}
