<?php

/*
 * Управление Привелегиями
 */

class C_Privs extends C_Base
{
    protected $privsAndRoles;
    protected $roles;
    protected $stat;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

        //Изменяем роль
        if (isset($_GET['id_role'])) {
            $this->mUser->changeRolePremission($_GET['id_role'], $_GET['priv_id']);
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
        //echo "<pre>";
        //var_dump($this->privsAndRoles);
        //Меняем роль у привелегии
        if ($this->ajax == true) {

            if (isset($_POST['priv']) && !empty($_POST['priv']) && isset($_POST['role']) && !empty($_POST['role'])) {

                $set = $this->mUser->setRoleToPriv($_POST['priv'][0], $_POST['role'][0]);
                if ($set) {
                    $this->stat['status'] = 'Ok';
                }
                else {
                    $this->stat['status'] = 'Error';
                }
            }
        }
    }


    protected function OnOutput()
    {
        $vars = ['privsAndRoles' => $this->privsAndRoles[0],
            'roles' => $this->roles];

        if ($this->ajax == true) {
            $r = $this->View('/ajax/tpl_new_role.php', ['stat' => $this->stat]);
            echo $r;
            die();
        }

        $this->content = $this->View('tpl_privs.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}