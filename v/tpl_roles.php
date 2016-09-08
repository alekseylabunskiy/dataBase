<div class="panel panel-default">
    <div class="panel-body text-center">
        <h3>Керування ролями</h3>
    </div>
</div>
<div class="panel panel-default col-md-2">
    <div class="panel-body text-center">
        <div>
            <a href="index.php?c=roles&create_role"><button class="btn btn-info">Створити Роль</button></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table  table-bordered text-center">
            <thead>
            <tr>
                <th class="text-center col-md-2">Ім'я Ролі</th>
                <th class="text-center col-md-9">Опис</th>
                <th class="text-center col-md-1">Дії</th>
            </tr>
            </thead>
            <tbody>
                <?php if(isset($listRoles)): ?>
                    <?php foreach ($listRoles as $list): ?>
                        <tr>
                            <td class="col-md-2"><?php echo $list['role_name']; ?></td>
                            <td class="col-md-9"><?php echo $list['description']; ?></td>
                            <td class="col-md-1"><a href="/index.php?c=roles&redact_role&role_id=<?php echo $list['role_id']; ?>" title="Редактировать"><span
                                        class="glyphicon glyphicon-pencil"></span></a>
                                <a href="/index.php?c=roles&delete_id=<?php echo $list['role_id']; ?>" title="Удалить"><span
                                        class="glyphicon glyphicon-trash conf-role-delete"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


