<div class="row">
    <div class="col-lg-10 col-md-offset-1">
        <div class="row">
                <a href="/index.php?c=single_user&id=<?php if (isset($one_person)) {echo $one_person['user_id'];} ?>">
                    <button class="btn btn-info">Редактировать</button>
                </a>
                <a href="/index.php?c=view&delete_id=<?php if (isset($one_person)) {echo $one_person['user_id'];} ?>">
                    <button class="btn btn-danger conf-delete">Удалить</button>
                </a>
        </div>
        <br>
        <label>Email</label>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php if (isset($one_person)) {echo $one_person['user_email'];} ?>
            </div>
        </div>
        <label>Роль</label>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php if (isset($one_person)) {echo $one_person['name_role'];} ?>
            </div>
        </div>
    </div>
</div>