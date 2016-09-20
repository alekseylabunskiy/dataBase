<div class="col-md-12">
    <h2>Керування ролями</h2>
</div>
<div class="col-md-12 text-right">
    <a href="/index.php?c=main&a=create_role">
        <button class="btn btn-info">Створити Роль</button>
    </a>
</div>
<div class="col-md-12">
    <h3></h3>
</div>
<div id="result">
    <div id="old_table" class="row">
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
                                    href="/index.php?c=main&a=redact_role&role_id=<?php echo $list['role_id']; ?>"
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
</div>
<div id="myModal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Попередження!</h4>
            </div>
            <div id="message" class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>



