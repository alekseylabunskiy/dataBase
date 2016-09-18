/*
 *
 */
var files;

$('input[type=file]').change(function(){
    files = this.files;
});


$('#send_file').click(function (event) {
    event.preventDefault();

    var data = new FormData();

    $.each( files, function( key, value ){
        data.append( key, value );
    });
    var url = 'index.php?c=single_user';

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function( respond){
            if( typeof respond.error === 'undefined' ){
                try {
                    var obj = jQuery.parseJSON(respond);
                    if (obj.name_image != null) {
                        var mBody = $('.m_body');
                        $('.modal-title').html('Завантажене фото');
                        var img = obj.name_image;
                        var src = '/v/files/user_avatar/originals/';
                        var ht = "<img src=" + src + img + " class=img-thumbnail alt='Фото'>";
                        mBody.html(ht);
                        var def = $('.btn-default');
                        def.attr('id','add_foto_to_user');
                        def.text('Замінити аватар');
                        var foto = $('#foto_file');
                        foto.html('');
                        foto.val('');
                        $('#not_add_foto').removeAttr('hidden');
                    } else {
                        $('#not_add_foto').attr('hidden','hidden');
                        $('.m_body').html(obj);
                    }
                }catch (err) {
                    $('.m_body').html('Файл завантажено.');
                }
            }
            else{
                console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
            }
        }
    });
});

$('.modal-footer').on('click','#add_foto_to_user',function () {
    var url = 'index.php?c=single_user';
    var status = 'ok';
    var data = {
        addSelectedFoto: status
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (sample) {
            try {
                var obj = jQuery.parseJSON(sample);
                if (obj.name_new_image != null) {
                    var img = obj.name_new_image;
                    var src = '/v/files/user_avatar/originals/';
                    var im = src + img;
                    $('#avatar_img').attr('src',im);
                }
            }
            catch (error){
                alert(sample);
            }
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
});
/*
 *
 */
$('#archiveImages').on('click','.deleteImg',function () {

    //выбираем удаляемое изображение
    var src = $(this).parent().html().toString();
    //id пользователя
    var id_m = src.match(/id=\d+/).toString();
    var id = id_m.match(/\d+$/);

    //название изображения
    var img = src.match(/[a-z0-9]{20,50}.[a-z]{3}/);

    var url = 'index.php?c=single_user&id=' + id;
    var data = {
        deletedImageName: img,
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (sample) {
            $('#archiveImages').html(sample);
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
    $('.oldOne').hide();
});