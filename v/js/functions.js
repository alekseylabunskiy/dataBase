//подтверждение на удаление пользователя
$('.conf-delete').click(function (event) {
    if (!confirm('Ви дійсно хочете видалити цього користувача?')){
        event.preventDefault();
    }
});

//подтверждение на удаление ролі
$('.conf-delete-role').click(function (event) {
    if (!confirm('Ви дійсно хочете видалити цю Роль?')){
        event.preventDefault();
    }
});