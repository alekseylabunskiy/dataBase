<div class="col-md-12 text-left  height90">
    <h2>Сменить настройки</h2>
</div>
<div class="row">
    <div class="col-lg-10 col-md-offset-1">
        <form role="form" action="/index.php?c=view&id=<?php if (isset($one_person)) {
            echo $one_person[0]['user_id'];
        } ?>" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" value="<?php if (isset($one_person)) {
                    echo $one_person[0]['user_email'];
                } ?>" name="n_user_email"
                       id="u_email" placeholder="Введите Email">
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="text" class="form-control"  name="n_user_pass"
                       id="u_password" placeholder="Пароль">
                <p class="help-block"></p>
            </div>
            <button type="submit" id="confUserData" class="btn btn-success" name="u_send">Отправить</button>
        </form>
    </div>
</div>