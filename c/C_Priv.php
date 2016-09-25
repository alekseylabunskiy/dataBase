<?php

/**
 *Управление привелегиями
 * @property array role
 * @property array privsAndRoles
 * @property array roles
 */
class C_Priv extends C_SiteController
{
    /*
     * Привелегии
     */
    public function actionIndex()
    {
        //Роли
        $this->roles = $this->mUser->getListRoles();

        //Роли и привелегии
        $this->privsAndRoles = $this->mUser->getPrivsAndRoles();

        //Вывод на страницу
        $vars = ['privsAndRoles' => $this->privsAndRoles[0], 'roles' => $this->roles];

        $this->render('privs/index.php', $vars);
    }

    /*
     *Обновляем зависимости
     */
    public function actionUpdate()
    {
        $set = $this->mUser->setRoleToPriv($_POST['priv'][0], $_POST['role'][0]);

        if ($set) {
            $stat['status'] = 'ok';
            echo json_encode($stat['status']);
        } else {
            $stat['status'] = 'Error';
            echo json_encode($stat['status']);
        }
    }

}