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

    /**
     *
     */
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

            //Создаем связь в Parent Child для новой роли. по умолчанию делаем ее потомком самой младшей роли

            if (!empty($_POST['name_new_role'] && !empty($_POST['description_new_role']))) {
                $this->mUser->createNewRoleRelationParentChild();
            }
            header('location:index.php?c=roles');
        }

        //Обновляем роль
        if (isset($_POST['update_role'])) {
            $this->mUser->updateRole($_POST['name_role'], $_POST['description_role'], $_GET['role_id']);
            header('location:index.php?c=roles');
        }

        //Удаляем Роль
        if ($this->ajax == true) {
            if (isset($_POST['iddel'])) {
                //Удаляем роль
                $this->delete_result = $this->mUser->deleteRole($_POST['iddel'][0]);

                if (isset($this->delete_result)) {
                    if ($this->delete_result == false) {
                        $this->del_message['text'] = 'Ви не можете видалити цю роль так як вона має привелегії та користувачів';
                    }
                    if ($this->delete_result == true) {
                        //Удаляем связь в таблице parent child
                        $this->mUser->deleteRelationParentChild($_POST['iddel'][0]);
                    }
                }

            }
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
            'oneRole' => $this->oneRole[0],
            'del_message' => $this->del_message,
            'link' => $this->link];

        if ($this->ajax == true) {
            if ($this->delete_result == false) {
                $r = $this->View('/ajax/tpl_new_role_table.php', ['del_message' => $this->del_message]);
                echo $r;
                die();
            }
            if ($this->delete_result == true) {
                $r = $this->View('/ajax/tpl_new_roles_list.php', $vars);
                echo $r;
                die();
            }
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