<?php

/**
 * Управление Ролями
 */
class C_Roles extends C_Base
{
    protected $listRoles;
    protected $oneRole;

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
            header('location:index.php?c=roles');
        }

        //Удаляем Роль
        if (isset($_GET['delete_id'])) {
            $this->mUser->deleteRole($_GET['delete_id']);
        }

        //Обновляем роль
        if (isset($_POST['update_role'])) {
            $this->mUser->updateRole($_POST['name_role'], $_POST['description_role'],$_GET['role_id']);
            header('location:index.php?c=roles');
        }

        //Все роли
        $this->listRoles = $this->mUser->getListRoles();

        //Одна роль
        if (isset($_GET['role_id'])) {
            $this->oneRole = $this->mUser->getOneRole($_GET['role_id']);
        }
    }


    protected function OnOutput()
    {

        $vars = ['listRoles' => $this->listRoles,
            'oneRole' => $this->oneRole[0]];

        $this->content = $this->View('tpl_roles.php', $vars);

        //Если передан гет на редактирование одной роли подключаем другой шаблон
        if (isset($_GET['redact_role'])) {
            $this->content = $this->View('tpl_redact_role.php', $vars);
        }
        //Если передан гет на создание роли подключаем другой шаблон
        if (isset($_GET['create_role'])) {
            $this->content = $this->View('tpl_create_role.php', $vars);
        }

        // C_Base.
        parent::OnOutput();
    }
}