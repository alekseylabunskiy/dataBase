<?php

/*
 * Управление Привелегиями
 */

class C_Privs extends C_Base
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

        //Изменяем роль
        if (isset($_GET['id_role'])){
            $this->mUser->changeRolePremission($_GET['id_role'],$_GET['priv_id']);
        }

        //Проверяем права доступа к данной странице
        if (!in_array('CAN_REDACT_PRIVS', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=error');
        }

        //Роли
        $this->roles = $this->mUser->getListRoles();
        //Роли и привелегии
        $this->privsAndRoles = $this->mUser->getPrivsAndRoles();
    }


    protected function OnOutput()
    {
        $vars = ['privsAndRoles' => $this->privsAndRoles[0],
            'roles' => $this->roles];

        $this->content = $this->View('tpl_privs.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}