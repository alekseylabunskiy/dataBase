$(function () {
    /*
     * Новые данные пользователя
     */
    $('#confUserData').click(function (event) {
        event.preventDefault();
        var user = getUserInfo();
        sendUpdatedUserData(user.id,user.email,user.pass,user.role);

    });
    function getUserInfo() {
        var obj = {};
        //ай ди пользователя
        var form = $('form').attr('action');

        var id = form.match(/[0-9]*$/).toString();
        // почта
        var email = $('#u_email').val();
        //Пароль
        var pass = $('#u_password').val();
        //роль
        var role = $('select :selected').val();

        obj = {
            id: id,
            email: email,
            pass: pass,
            role: role
        };

       return obj;
    }

    function sendUpdatedUserData(id,email,pass,role) {

        var url = 'index.php?c=user&a=update';

        var data = {
            id: id,
            email: email,
            pass: pass,
            role: role
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (sample) {
                try{
                    var obj = jQuery.parseJSON(sample);
                    $('#user_upd').html(obj);
                }catch (error) {

                }

            },
            error: function (jqXHR, exception) {

            }
        });
    }
    //подтверждение на удаление пользователя
    $('.conf-delete').click(function (event) {
        if (!confirm('Ви дійсно хочете видалити цього користувача?')){
            event.preventDefault();
        }
    });
});

