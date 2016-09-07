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

        //Удаляем пользователя
        if (isset($_GET['delete_id'])) {
            $this->mysqli->Delete('users', "user_id = {$_GET['delete_id']}");
            header('Location:index.php?c=main_list');
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