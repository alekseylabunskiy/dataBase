<?php

/*
 *  Базовый контроллер сайта
 */

abstract class C_Base extends C_Controller
{
    public $title = 'БАЗА ДАНИХ КОРИСТУВАЧІВ';
    protected $mysqli;
    protected $image;
    protected $needLogin;
    protected $user;
    protected $name;
    protected $mUser;
    protected $content;
    protected $users;
    protected $mFunctions;
    protected $canPrivsRoles;
    protected $canRedactUsers;
    protected $canUser;
    protected $errors;
    protected $permissions;
    protected $ajax;
    private $start_time;


    function __construct()
    {
        $this->needLogin = true;
        $this->user = null;
    }

    protected function OnInput()
    {
        //Засекаем время начала работы скрипта
        $this->start_time = microtime(true);

        //Подключаем модели
        $this->mysqli = M_MSQL::Instance();
        $this->mUser = M_Users::Instance();
        $this->mFunctions = M_Functions::Instance();
        $this->mErrors = M_Errors::Instance();
        $this->image = M_Image::Instance();

        //Очищаем старые сесии
        $this->mUser->ClearSessions();

        //Проверка существования изображения аватара
        $this->image->removeReferencesToNonexistentImage();

        //logout
        if (isset($_GET['logout'])) {
            $this->mUser->Logout();
            header("Location:index.php?c=login");
        }

        //Получаем пользователя
        $this->user = $this->mUser->Get();

        //если пользователь залогинен передаем его имя
        if (!empty($this->user)) {
            $this->name = $this->user['user_name'];
        }

        //Проверяем разрешения пользователя
        $this->permissions = $this->mUser->getAllPrivsCurrentUser($this->user['role_id']);
        //проверяем на ajax запрос

        $this->ajax = $this->mFunctions->getIsAjaxRequest();
    }

    protected function OnOutput()
    {
        $vars = ['content' => $this->content,
            'permissions' => $this->permissions,
            'title' => $this->title,
            'currentUser' => $this->user['user_name']];

        $page = $this->View('tpl_main.php', $vars);

        $time = microtime(true) - $this->start_time;
        $page .= "<!-- Время работы скрипта: $time сек.-->";

        echo $page;
    }
}
