$(function () {
    //подтверждение на удаление пользователя
    $('.conf-delete').click(function (event) {
        if (!confirm('Ви дійсно хочете видалити цього користувача?')){
            event.preventDefault();
        }
    });
    //подтверждение на удаление Роли
    $('.conf-role-delete').click(function (event) {
        if (!confirm('Ви дійсно хочете видалити цю роль?')){
            event.preventDefault();
        }
    });
});



