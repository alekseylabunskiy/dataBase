$('#result').on("click", ".delete", function (event) {

    event.preventDefault();

    var param = parseGetParams(this.href);

    doSets(param.deleteId);
});

function parseGetParams(get) {
    var params = {};

    if (get != null) {

        var searchId = get.match(/delete_id=[0-9]{1,10000}/).toString();

        var id = searchId.match(/[0-9]{1,10000}/);

        params =
        {
            deleteId: id
        };
        return params;
    }
    return false;
}
function doSets(id) {

    var url = 'index.php?c=roles';

    var data = {
        iddel: id
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (sample) {

            var obj = jQuery.parseJSON(sample);

            $('.modal-content').html('<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button><h4 class="modal-title">Попередження!</h4> </div> <div id="message" class="modal-body"></div> <div class="modal-footer"> <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>');

            $('.modal-body').html(obj.text);
            setTimeout(function () {location.reload(true)},3000);
        },
        error: function () {
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