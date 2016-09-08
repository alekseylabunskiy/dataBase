<div>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h3>Керування Привелегіями</h3>
        </div>
    </div>
</div>
<div>
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">Прівелегія</th>
            <th class="text-center">Опис</th>
            <th class="text-center">Роль</th>
            <th class="text-center">Дія</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($privsAndRoles)): ?>
            <?php foreach ($privsAndRoles as $list): ?>
                <tr>
                    <td><?php echo $list['name']; ?></td>
                    <td><?php echo $list['description']; ?></td>
                    <td>
                        <form action="/index.php?c=privs" method="post" role="form">
                            <select class="form-control" name="new_role" title="">
                                <option selected value=""><?php echo $list['role_name']; ?></option>
                                <?php if (isset($roles)): ?>
                                    <?php foreach ($roles as $rolesList): ?>
                                        <option class="new_role" value="<?php echo $rolesList['role_id']; ?>"><?php echo $rolesList['role_name']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <input hidden type="text" class="hiddenPriv" name="new_priv" title="" value="<?php echo $list['priv_id']?>">
                    </td>
                    <td>
                            <button type="submit" class="btn btn-info change_role" data-toggle="modal" data-target="#myModal">Змінити</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Повідомлення</h4>
            </div>
            <div class="modal-body">Роль успішно змінено</div>
            <div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>
        </div>
    </div>
</div>

