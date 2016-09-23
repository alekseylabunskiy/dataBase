<?php

/**
 * @property M_MSQL mysqli;
 * @property M_Users mUser;
 * @property M_Functions mFunctions;
 * @property $content;
 * @property $title;
 * @property $user;
 * @property array permissions
 * @property bool ajax
 * @property M_Image mImage
 * @property M_Errors mErrors
 */
class C_SiteController extends C_Controller
{
    protected $title = "Керування користувачами";
    protected $user = '';

    function __construct()
    {
        //Подключаем модели
        $this->mysqli = M_MSQL::Instance();
        $this->mUser = M_Users::Instance();
        $this->mFunctions = M_Functions::Instance();
        $this->mImage = M_Image::Instance();
        $this->mErrors = M_Errors::Instance();

        //Очищаем старые сесии
        $this->mUser->ClearSessions();

        //Проверка существования изображения аватара
        $this->mImage->removeReferencesToNonexistentImage();

        //Получаем пользователя
        $this->user = $this->mUser->Get();

        //Проверяем разрешения пользователя
        $this->permissions = $this->mUser->getAllPrivsCurrentUser($this->user['role_id']);

        //Проверяем права доступа к страницам
        if (!empty($_GET['c']) && !empty($_GET['a'])) {
            $this->mFunctions->getAccessToPage($this->permissions, $_GET['c'], $_GET['a']);
        }
        //проверяем на ajax запрос
        $this->ajax = $this->mFunctions->getIsAjaxRequest();

    }

    public function render($template, $var)
    {
        $this->content = $this->setView($template, $var);

        $vars = ['content' => $this->content, 'title' => $this->title, 'user' => $this->user, 'permissions' => $this->permissions];
        parent::setUpView('layouts/main.php', $vars);
    }
}