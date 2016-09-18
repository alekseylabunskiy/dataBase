$(function () {
    /*
     *
     */

    $(".rolesPrivsSelect").change(function () {
        var options = $(this).val();
        var params = parseGetParams(options);
        doSet(params.priv, params.role);
    });

    function parseGetParams(get) {
        var params = {};

        if (get != null) {
            var searchRole = get.match(/role_id=[0-9]{1}/).toString();
            var role = searchRole.match(/[0-9]{1}/);

            var searchPriv = get.match(/priv_id=[0-9]{1}/).toString();
            var priv = searchPriv.match(/[0-9]{1}/);

            params =
            {
                role: role,
                priv: priv
            };
            return params;
        }
        return false;
    }

    function doSet(priv, role) {
        var url = 'index.php?c=privs';

        var data = {
            priv: priv,
            role: role
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (sample) {

            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 0) {
                    alert('НЕ подключен к интернету!');
                } else if (jqXHR.status == 404) {
                    alert('НЕ найдена страница запроса [404])');
                } else if (jqXHR.status == 500) {
                    alert('НЕ найден домен в запросе [500].');
                } else if (exception === 'parsererror') {
                    alert("Ошибка в коде: \n" + jqXHR.responseText);
                } else if (exception === 'timeout') {
                    alert('Не ответил на запрос.');
                } else if (exception === 'abort') {
                    alert('Прерван запрос Ajax.');
                } else {
                    alert('Неизвестная ошибка:\n' + jqXHR.responseText);
                }
            }
        });
    }
});
