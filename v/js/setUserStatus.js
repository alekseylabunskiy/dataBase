$('.status_user').click(function () {

    var condition = $(this).prop("checked");
    var id = $(this).attr('id');

    doAjax(condition, id);
});

function doAjax(condition, id) {

    var url = 'index.php?c=user&a=status';

    setTimeout(function () {
        var data = {
            condition: condition,
            id: id
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
            },
        });
    }, 200);
}
