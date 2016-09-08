<div class="row">
    <div class="col-lg-10 col-md-offset-1">
        <form role="form" action="/index.php?c=single_user&id=<?php if (isset($one_person)) {
            echo $one_person['user_id'];
        } ?>" method="post">
            <div class="form-group">
                <label for="email">Пошта</label>
                <input type="email" class="form-control" value="<?php if (isset($one_person)) {
                    echo $one_person['user_email'];
                } ?>" name="n_user_email"
                       id="u_email" placeholder="Введите Email">
            </div>
            <div class="form-group">
                <label for="pass">Пароль</label>
                <input type="text" class="form-control" value="" name="n_user_pass"
                       id="u_password" placeholder="Пароль">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="new_role_user">Роль</label>
                <select class="form-control" name="new_role_user" id="" title="new role">
                    <option value="<?php if (isset($oneRole)){echo $oneRole[0]['role_id'];}?>" selected><?php if (isset($oneRole)){echo $oneRole[0]['role_name'];}?></option>
                    <?php if (isset($roles)): ?>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['role_id']?>"><?php echo $role['role_name']?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" id="confUserData" class="btn btn-success" name="u_send">Отправить</button>
        </form>
    </div>
</div>
