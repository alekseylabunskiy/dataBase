<?php

/**
 * Класс обработки Ajax запросов
 */
class C_Ajax extends C_Base
{
    protected $privsAndRoles;
    protected $roles;
    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();
        //обновляем статус пользователя

        if (isset($_POST['condition']) && isset($_POST['id']) && !empty($_POST['condition']) && !empty($_POST['id'])) {
            $this->mUser->setStatus($_POST['id'], $_POST['condition']);
        }

        //Меняем роль у привелегии
        if (isset($_POST['priv']) && !empty($_POST['priv']) && isset($_POST['role']) && !empty($_POST['role'])) {

            $this->mUser->setRoleToPriv($_POST['priv'][0],$_POST['role'][0]);
            //Роли
            $this->roles = $this->mUser->getListRoles();
            //Роли и привелегии
            $this->privsAndRoles = $this->mUser->getPrivsAndRoles();
        }
    }


    protected function OnOutput()
    {
        $vars = ['privsAndRoles' => $this->privsAndRoles[0],
            'roles' => $this->roles];

        $page = $this->View('tpl_ajax.php', $vars);

        echo $page;
    }
}