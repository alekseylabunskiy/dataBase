<?php

/**
 * Контроллер управления ролями
 * @property bool|mysqli_result delete_result
 * @property array|bool oneRole
 */
class C_Role extends C_SiteController
{
    /*
     * Управление Ролями
     */
    public function actionIndex()
    {
        //Все роли
        $listRoles = $this->mUser->getListRoles();

        $vars = ['listRoles' => $listRoles];

        //Вывод на страницу
        $this->render('role/index.php', $vars);
    }

    /*
     * Удаляем Роль
     */
    public function actionDeleteRole()
    {
        $del_message = '';

        //Удаляем Роль
        if ($this->ajax == true) {
            if (isset($_POST['iddel'])) {
                //Удаляем роль
                $this->delete_result = $this->mUser->deleteRole($_POST['iddel'][0]);

                if (isset($this->delete_result)) {
                    if ($this->delete_result == false) {
                        $del_message['text'] = 'Ви не можете видалити цю роль так як вона має привелегії та користувачів';
                        echo json_encode($del_message['text']);
                    }
                    if ($this->delete_result == true) {
                        //Удаляем связь в таблице parent child
                        $this->mUser->deleteRelationParentChild($_POST['iddel'][0]);
                        //Все роли отдаем в новую таблицу
                        $listRoles = $this->mUser->getListRoles();

                        $vars = ['listRoles' => $listRoles];
                        $this->render('ajax/tpl_new_roles_list.php', $vars,true);
                    }
                }
            }
        }
    }
    /*
    * Создаем роль
    */
    public function actionCreate()
    {
        //Добавляем роль
        if (isset($_POST['create_new_role'])) {

            $this->mUser->createRole($_POST['name_new_role'], $_POST['description_new_role']);

            //Создаем связь в Parent Child для новой роли. по умолчанию делаем ее потомком самой младшей роли

            if (!empty($_POST['name_new_role'] && !empty($_POST['description_new_role']))) {
                $this->mUser->createNewRoleRelationParentChild();
            }
            $this->mFunctions->redirect(['c' => 'role','a' => 'index']);
        }

        //Вывод на страницу
        $vars = [];
        $this->render('role/create.php', $vars);
    }

    /*
     * Редактируем роль
     */
    public function actionUpdate()
    {
        //Обновляем роль
        if (isset($_POST['update_role'])) {
            $this->mUser->updateRole($_POST['name_role'], $_POST['description_role'], $_GET['role_id']);

            $this->mFunctions->redirect(['c' => 'role','a' => 'index']);
        }

        //Одна роль
        if (isset($_GET['role_id'])) {
            $this->oneRole = $this->mUser->getOneRole($_GET['role_id']);
        }

        //Вывод на страницу
        $vars = ['oneRole' => $this->oneRole[0]];

        $this->render('role/update.php', $vars);
    }
}