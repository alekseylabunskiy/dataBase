<?php

/**
 *Класс позволяет редактировать запись одного пользователя
 * @property string content
 */
class C_SingleUser extends C_Base
{
    protected $one_person;
    protected $roles;
    protected $json;
    protected $user_id;
    protected $name_foto;
    private $oneRole;
    protected $user_images;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();
        if (isset($_GET['id'])) {
            $this->user_id = $_GET['id'];

            $this->mUser->setSessionUserId($_GET['id']);
        }
        // Меняем фото при выборе ее из архива
        if (isset($_GET['image_id'])) {
            $id = $_GET['image_id'];
            $this->mUser->updateItem('users', ['user_avatar' => $id], 'user_id ='.$this->user_id);
        }
        //загружаем файлы
        if ($this->ajax == true) {
            if (isset($_POST)) {

                if (!isset($_POST['addSelectedFoto']) && empty($_FILES) && !isset($_POST['deletedImageName'])) {
                    $this->json = 'Виберіть файл!';
                }

                $sizes = array(
                    '100' => ['width' => 100, 'heigth' => 100],
                );

                foreach ($_FILES as $files) {
                    //Создаем новое имя файла
                    $this->name_foto = $this->image->setNewNameFile();

                    $this->image->setSessionFoto($this->name_foto);

                    if (!isset($SESSION['name_foto']) || empty($SESSION['name_foto'])) {
                        $SESSION['name_foto'] = $this->name_foto;
                    }

                    //Проверяем на ошибки. Если нет то сохраняем изображение, а так, выводим ошибку
                    $errors = $this->image->checkImage();

                    if (empty($errors) && !empty($this->name_foto)) {

                        //Сохраняем имя изображения в базу
                        $this->image->saveTodB($SESSION['name_foto'], $this->user['user_id']);

                        //Сохраняем изображение на сервер
                        $this->image->SaveResized($sizes, $this->name_foto);

                        //Вытаскиваем только что добавленное изображение
                        $foto = $this->image->selectNewFoto($this->name_foto);
                        //Передаем имя изображения
                        $this->json['name_image'] = $foto[0]['name_image'];
                        //Очищаем массив $_FILES
                        $_FILES = null;
                        $_POST = null;
                    } else {
                        $this->json = $errors;
                    }
                }

                //Присваиваем новое фото пользователю
                if (isset($_POST['addSelectedFoto'])) {

                    //Достаем имя фотографии
                    $name_f = $this->image->getSessionFoto();

                    //Ай ди пользователя
                    $user_id_f = $this->mUser->getSessionUserId();

                    $this->json['name_new_image'] = $name_f;

                    $this->image->addImageToUser($user_id_f, $name_f);

                    //Обновляем дату редактирования
                    $this->mUser->updateItem('users', ['user_time_update' => date("Y-m-d H:i:s")], "user_id=" . $user_id_f);
                }
            }
        }

        //Удаляем одно изображение
        if (isset($_POST['deletedImageName'])) {
            $name_foto = $_POST['deletedImageName'][0];
            $name_foto = trim($name_foto);

            $this->mUser->deleteItem('images',"name_image = '$name_foto'");

            $this->image->deleteSelectedImage($name_foto);
        }
        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($_POST['n_user_email'], $_POST['n_user_pass'], $_POST['new_role_user'], $this->user_id);

            header("Location: index.php?c=view&id=$this->user_id");
        }
        //Все роли
        $this->roles = $this->mUser->getListRoles();

        //Роль пользователя
        $this->oneRole = $this->mUser->getOneUserRole($this->user_id);

        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($this->user_id);

        //фото пользователя
        $this->user_images = $this->mUser->getUserImages($this->user_id);

    }

    protected function OnOutput()
    {
        $vars = ['title' => $this->title,
            'one_person' => $this->one_person,
            'permissions' => $this->permissions,
            'oneRole' => $this->oneRole,
            'roles' => $this->roles,
            'stat' => $this->json,
            'user_images' => $this->user_images
        ];
        if (isset($_POST['deletedImageName'])) {
            $r = $this->View('/ajax/tpl_new_table_old_imgs.php',$vars);
            echo $r;
            die();
        }

        if ($this->ajax == true) {
            $r = $this->View('/ajax/tpl_new_role.php', ['stat' => $this->json]);
            echo $r;
            die();
        }

        $this->content = $this->View('tpl_one_user.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}