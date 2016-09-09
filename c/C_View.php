<?php

/**
 * Просмотр данных одного пользователя
 */
class C_View extends C_Base
{
    protected $one_person;
    protected $email;
    protected $avatar;
    protected $role;
    protected $pass;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {

        // C_Base.
        parent::OnInput();
        $user_id = $_GET['id'];

        //Удаляем пользователя
        if (isset($_GET['delete_id'])) {
            $this->mysqli->Delete('users', "user_id = {$_GET['delete_id']}");
            header('Location:index.php?c=main_list');
        }
        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($user_id);
    }


    protected function OnOutput()
    {
        $vars = ['title' => $this->title,
            'canRedactUsers' => $this->canRedactUsers,
            'one_person' => $this->one_person[0]];

        $this->content = $this->View('tpl_view.php', $vars);

        // C_Base.
        parent::OnOutput();
    }

}