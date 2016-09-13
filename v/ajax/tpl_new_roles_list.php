<div id="new_table" class="row">
    <div class="col-md-12">
        <table class="table  table-bordered table-striped text-center">
            <thead>
            <tr>
                <th class="text-center col-md-2">Ім'я Ролі</th>
                <th class="text-center col-md-9">Опис</th>
                <th class="text-center col-md-1">Дії</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($listRoles)): ?>
                <?php foreach ($listRoles as $list): ?>
                    <tr>
                        <td class="col-md-2"><?php echo $list['role_name']; ?></td>
                        <td class="col-md-9"><?php echo $list['description']; ?></td>
                        <td class="col-md-1"><a
                                href="/index.php?c=roles&redact_role&role_id=<?php echo $list['role_id']; ?>"
                                title="Редактировать"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                            <a class="delete" data-toggle="modal" data-target="#myModal"
                               href="#delete_id=<?php echo $list['role_id']; ?>"
                               title="Удалить"><span
                                    class="glyphicon glyphicon-trash roles-delete"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>