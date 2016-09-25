<div class="col-md-12 text-left  height90">
    <h2>Додати користувача</h2>
</div>
<form role="form" action="index.php?c=user&a=create" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Им'я</label>
        <input type="text" class="form-control" name="new_user_name" id="name" placeholder="Им'я" required>
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="new_user_email" placeholder="Введіть email" required>
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label for="pass">Пароль</label>
        <input type="password" class="form-control" name="new_user_password" id="new_user_password" placeholder="Пароль"
               required>
        <p class="help-block"></p>
    </div>
    <div class="form-group">
        <label for="filename">Завантажити аватар</label>
        <input id="foto_file" type="file" name="file_name"/>
        <p class="help-block">Завантажувані фотографії повинні бути в форматі jpg,gif,png, і розміром не
            більше 1Мб</p>
    </div>
    <button type="submit" id="create_user" name="create_user" class="btn btn-success">Создати</button>
</form>
