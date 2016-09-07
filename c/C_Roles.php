<?php

/**
 * Управление Ролями
 */
class C_Roles extends C_Base
{
    protected $listRoles;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

        //Проверяем права доступа к данной странице
        if (!in_array('CAN_REDACT_ROLES', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=error');
        }
        //Добавляем роль
        if (isset($_POST['create_new_role'])) {
            $this->mUser->createRole($_POST['name_new_role'], $_POST['description_new_role']);
        }
        //Удаляем Роль
        if (isset($_POST['del_role'])) {

            $this->mUser->deleteRole($_POST['delete_role']);
        }
        //Все роли
        $this->listRoles = $this->mUser->getListRoles();

    }


    protected function OnOutput()
    {
        $vars = ['listRoles' => $this->listRoles];

        $this->content = $this->View('tpl_roles.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}