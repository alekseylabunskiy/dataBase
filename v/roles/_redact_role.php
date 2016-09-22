<div class="panel panel-default">
    <div class="panel-body text-center">
        <h3>Редагування ролі</h3>
    </div>
</div>
<form action="/index.php?c=roles&a=redact_role&role_id=<?php if (isset($oneRole)) {echo $oneRole['role_id'];} ?>" role="form" method="post">
    <div class="form-group">
        <label for="name_role">Ім'я ролі</label>
        <input type="text" class="form-control" required id="name_role" name="name_role" value="<?php if (isset($oneRole)) {
            echo $oneRole['role_name'];
        } ?>">
    </div>
    <div class="form-group">
        <label for="oneRole">Опис</label>
        <input type="text" class="form-control" required name="description_role" id="oneRole" value="<?php if (isset($oneRole)) {
            echo $oneRole['description'];
        } ?>">
    </div>
    <button type="submit" class="btn btn-success" name="update_role">Змінити</button>
</form>