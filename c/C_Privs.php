<?php

/**
 *Управление привелегиями
 * @property array roles
 * @property array privsAndRoles
 */
class C_Privs extends C_SiteController
{
    /*
     * Управление привелегиями
     */
    public function actionIndex()
    {
        //Проверяем права доступа к данной странице

        if (!in_array('CAN_REDACT_PRIVS', $this->permissions)) {
            $this->mErrors->wrongAuthorization();
            header('location:index.php?c=errors&a=wrong_authorization');
        }
        $stat = [];
        //Изменяем роль
        if (isset($_GET['id_role'])) {
            $this->mUser->changeRolePremission($_GET['id_role'], $_GET['priv_id']);
        }

        //Роли
        $this->roles = $this->mUser->getListRoles();

        //Роли и привелегии
        $this->privsAndRoles = $this->mUser->getPrivsAndRoles();

        //Меняем роль у привелегии
        if ($this->ajax == true) {

            if (isset($_POST['priv']) && !empty($_POST['priv']) && isset($_POST['role']) && !empty($_POST['role'])) {

                $set = $this->mUser->setRoleToPriv($_POST['priv'][0], $_POST['role'][0]);
                if ($set) {
                    $stat['status'] = 'ok';
                } else {
                    $stat['status'] = 'Error';
                }
            }
        }

        if ($this->ajax == true) {
            $r = $this->setUpView('/ajax/tpl_new_role.php', ['stat' => $stat]);
            echo $r;
            die();
        }

        //Вывод на страницу
        $vars = ['privsAndRoles' => $this->privsAndRoles[0], 'roles' => $this->roles];

        $this->render('privs/_privs.php', $vars);
    }

}