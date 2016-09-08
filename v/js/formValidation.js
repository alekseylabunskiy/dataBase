$(function () {
    /**
     * Провряет валидность введенных значений адреса ел. почты и пароля
     *
     */
    if (document.getElementById('login_btn') != null) {
        var button = document.getElementById('login_btn');

        button.addEventListener("click", function (event) {
            checkEmail(event);
            checkPassword(event);
        });
    }
    //-------------------------//
    //Проверяем валидность адреса почты

    function checkEmail(event) {

        var validEmail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
        var email = document.getElementById('u_email');
        var emailValue = email.value;

        if(!emailValue.match(validEmail)) {
            event.preventDefault();
            email.parentNode.classList.add('has-error');
            email.nextElementSibling.innerHTML = 'Будь ласка, введіть коректну адресу';
        }else{
            email.parentNode.classList.remove('has-error');
            email.nextElementSibling.innerHTML = '';
            email.parentNode.classList.add('has-success');
        }
    }
    //-------------------------//
    //Проверяем пароль
    function checkPassword(event){

        var pass = document.getElementById('u_password');
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
});