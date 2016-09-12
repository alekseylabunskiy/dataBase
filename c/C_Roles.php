<?php

/**
 * Управление Ролями
 */
class C_Roles extends C_Base
{
    protected $listRoles;
    protected $oneRole;
    protected $delete_result;
    protected $link;
    protected $del_message;

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

        //Обновляем роль
        if (isset($_POST['update_role'])) {
            $this->mUser->updateRole($_POST['name_role'], $_POST['description_role'], $_GET['role_id']);
            header('location:index.php?c=roles');
        }

        //Все роли
        $this->listRoles = $this->mUser->getListRoles();

        //Одна роль
        if (isset($_GET['role_id'])) {
            $this->oneRole = $this->mUser->getOneRole($_GET['role_id']);
        }

        //Удаляем Роль
        if ($this->ajax == true) {
            if (isset($_POST['iddel'])) {
                $this->delete_result = $this->mUser->deleteRole($_POST['iddel'][0]);
                if (isset($this->delete_result)) {
                    if ($this->delete_result == false) {
                        $this->del_message['text'] = 'Ви не можете видалити цю роль так як вона має привелегії та користувачів';
                    }
                    if ($this->delete_result == true) {
                        $this->del_message['text'] = 'Ви можете видалити цю роль.';
                    }
                }
            }
        }
    }

    protected function OnOutput()
    {

        $vars = ['listRoles' => $this->listRoles,
            'oneRole' => $this->oneRole[0],
            'del_message' => $this->del_message,
            'link' => $this->link];

        if ($this->ajax == true) {
            $r = $this->View('/ajax/tpl_new_role_table.php', ['del_message' => $this->del_message]);
            echo $r;
            die();
        }
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