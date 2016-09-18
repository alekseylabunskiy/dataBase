<?php

/**
 * Управление главным списком пользователейы
 */
class C_MainList extends C_Base
{
    protected $list;
    protected $currentUser;
    protected $one_person;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        parent::OnInput();

        if (!in_array('USER_PRIV', $this->permissions)) {
            header('location:index.php?c=login');
        }
        //пользователь кабинета
        $this->one_person = $this->mUser->getOneUser($this->user['user_id']);

        //Удаляем пользователя, и им загруженные фото. (удаление фото настроено только из двух папок, /originals/ и /resized/100).
        //При появлении других папок с изображениями настроить пути удаления в функции deleteUser($id).

        if (isset($_GET['delete_id'])) {

            $id = $_GET['delete_id'];

            $this->mUser->deleteUser($id);

            header('Location:index.php?c=main_list');
        }
        //меняем статус пользователя ajax запросом
        if ($this->ajax == true) {
            if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {
                $this->mUser->setStatus($_POST['id'], $_POST['condition']);
            }
        }
        //список всех пользователей
        $this->list = $this->mUser->getUsers();

    }


    protected function OnOutput()
    {
        $vars = ['title' => $this->title,
            'permissions' => $this->permissions,
            'list_users' => $this->list,
            'one_person' => $this->one_person,
        ];

        $this->content = $this->View('tpl_main_list.php', $vars);

        if (isset($_GET['kabinet'])) {
            $this->content = $this->View('tpl_kabinet.php', $vars);
        }
        // C_Base.
        parent::OnOutput();
    }
}