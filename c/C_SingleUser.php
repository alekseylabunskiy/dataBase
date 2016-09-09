<?php

/**
 *Класс позволяет редактировать запись одного пользователя
 * @property string content
 */
class C_SingleUser extends C_Base
{
    protected $one_person;
    private $email;
    private $pass;
    private $oneRole;
    protected $roles;
    private $role;

    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

        $user_id = $_GET['id'];
        //
        if (isset($_POST['n_user_email']) && !empty($_POST['n_user_email']) && isset($_POST['n_user_pass']) && isset($_POST['new_role_user'])) {

            $this->email = $_POST['n_user_email'];
            $this->pass = $_POST['n_user_pass'];
            $this->role = $_POST['new_role_user'];
        }

        //Отправляем обновленные данные пользователя
        if (isset($_POST['u_send'])) {

            $this->mUser->UpdateUser($this->email, $this->pass,$this->role, $user_id);

            header("Location: index.php?c=view&id=$user_id");
        }
        //Все роли
        $this->roles = $this->mUser->getListRoles();
        //Роль пользователя
        $this->oneRole = $this->mUser->getOneUserRole($user_id);

        //Список рараметров одного пользователя
        $this->one_person = $this->mUser->getOneUser($user_id);
    }


    protected function OnOutput()
    {
        $vars = ['title' => $this->title,
            'one_person' => $this->one_person[0],
            'permissions' => $this->permissions,
            'oneRole' => $this->oneRole,
            'roles' => $this->roles
        ];

        $this->content = $this->View('tpl_one_user.php', $vars);

        // C_Base.
        parent::OnOutput();
    }
}