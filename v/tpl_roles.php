<div class="panel panel-default">
    <div class="panel-body text-center">
        <h3>Керування ролями</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table  table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center">Ім'я Ролі</th>
                <th class="text-center">Опис</th>
            </tr>
            </thead>
            <tbody>
                <?php if(isset($listRoles)): ?>
                    <?php foreach ($listRoles as $list): ?>
                        <tr>
                            <td><?php echo $list['role_name']; ?></td>
                            <td><?php echo $list['description']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Створити Роль</h3>
            </div>
            <div class="panel-body">
                <form action="/index.php?c=roles" method="post" role="form">
                    <div class="form-group">
                        <label for="name_new_role">Ім'я нової Ролі</label>
                        <input class="form-control" type="text" name="name_new_role" title="Нова роль">
                    </div>
                    <div class="form-group">
                        <label for="description_new_role">Опис нової Ролі</label>
                        <input class="form-control" type="text" name="description_new_role" title="Опис">
                    </div>
                    <button class="btn btn-info" type="submit" name="create_new_role">Створити</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Видалити Роль</h3>
            </div>
            <div class="panel-body">
                <form action="/index.php?c=roles" method="post" role="form">
                    <select class="form-control" name="delete_role">
                        <option selected></option>
                        <?php if (isset($listRoles)): ?>
                            <?php foreach ($listRoles as $list): ?>
                                <option value="<?php echo $list['role_id']?>"><?php echo $list['role_name']?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <br>
                    <button class="btn btn-danger conf-delete-role" type="submit" name="del_role">Видалити</button>
                </form>
            </div>
        </div>
    </div>
</div>

