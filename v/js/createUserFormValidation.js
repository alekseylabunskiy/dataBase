if (document.getElementById('create_user') != null) {
    var button = document.getElementById('create_user');
    button.addEventListener("click", function (event) {
        checkPassword(event);
    });
}

function checkPassword(event){

    var pass = document.getElementById('new_user_password');
    var passValue = pass.value;
    var stringTwo = passValue.toLowerCase();

    //проверяем на длинну пароля
    if (passValue.length < 8) {
        event.preventDefault();
        pass.parentNode.classList.add('has-error');
        pass.nextElementSibling.innerHTML = 'Пароль повинен бути більше ніж 8 знаків';
    } else {
        //проверка на наличие цифр в пароле
        if(!parseInt(passValue.replace(/\D+/g,""))) {
            event.preventDefault();
            pass.parentNode.classList.add('has-error');
            pass.nextElementSibling.innerHTML = 'Пароль Повинен повинен містити цифри';
        } else {
            pass.parentNode.classList.remove('has-error');
            pass.nextElementSibling.innerHTML = '';
            pass.parentNode.classList.add('has-success');
        }
        //проеряем на заглавные буквы
        if (stringTwo == passValue) {
            event.preventDefault();
            pass.parentNode.classList.add('has-error');
            pass.nextElementSibling.innerHTML = 'У паролі повинні бути присутніми великі літери';
        }
    }
    pass.parentNode.classList.add('has-success');
}
