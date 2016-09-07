<div class="panel panel-default">
    <div class="panel-body text-center">
        <h3>Додати користувача</h3>
    </div>
</div>
<form role="form" action="index.php?c=add_user" method="post">
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
    <button type="submit" id="create_user" name="create_user" class="btn btn-success">Создати</button>
</form>