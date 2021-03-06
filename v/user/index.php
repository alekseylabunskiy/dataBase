<table class="table table-bordered table-striped text-center">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">Роль</th>
        <th class="text-center">Ім'я</th>
        <th class="text-center">Email</th>
        <th class="text-center">Аватарка</th>
        <th class="text-center">Зареєстрованний</th>
        <th class="text-center">Активність</th>
        <th class="text-center">Редагувався</th>
        <?php if (isset($permissions)): ?>
            <?php if (in_array('USER_STATUS', $permissions)): ?>
                <th class="text-center">Статус</th>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($permissions)): ?>
            <?php if (in_array('USER_UPDATE', $permissions)): ?>
                <th class="text-center"></th>
            <?php endif; ?>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($list_users)): ?>
        <?php foreach ($list_users as $list): ?>
            <tr>
                <td><?php echo $list['user_id']; ?></td>
                <td><?php echo $list['name_role']; ?></td>
                <td><?php echo $list['user_name']; ?></td>
                <td><?php echo $list['user_email']; ?></td>
                <td class="col-xs-1">
                    <a class="colorbox"  href="/v/files/user_avatar/originals/<?php echo $list['user_avatar']; ?>"><img src="/v/files/user_avatar/resized/100/<?php echo $list['user_avatar']; ?>" class="img-rounded"
                         alt="Добавьте фото"></a>
                </td>
                <td><?php echo $list['user_date_register']; ?></td>
                <td><?php echo $list['user_last_active']; ?></td>
                <td><?php echo $list['user_time_update']; ?></td>
                <?php if (isset($permissions)): ?>
                <?php if (in_array('USER_STATUS', $permissions)): ?>
                        <td>
                            <form action="/index.php?c=main&c=index" method="get">
                                <div class="checkbox">
                                    <label for="user_status">
                                        <input class="status_user" id="<?php echo $list['user_id']; ?>" type="checkbox"
                                               name="user_status" <?php echo $list['checked']; ?>/>
                                    </label>
                                </div>
                            </form>
                        </td>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($permissions)): ?>
                    <?php if (in_array('USER_UPDATE', $permissions)): ?>
                        <td>
                            <a href="/index.php?c=user&a=update&id=<?php echo $list['user_id']; ?>" title="Редактировать"><span
                                    class="glyphicon glyphicon-pencil"></span></a>
                            <a href="/index.php?c=user&a=delete&delete_id=<?php echo $list['user_id']; ?>" title="Удалить"><span
                                    class="glyphicon glyphicon-trash conf-delete"></span></a>
                        </td>
                    <?php endif; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>


