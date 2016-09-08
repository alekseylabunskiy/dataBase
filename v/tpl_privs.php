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
                            <button type="submit" class="btn btn-info change_role">Змінити</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<!---
<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle col-sm-7 col-md-offset-3" type="button"
            data-toggle="dropdown"><? /*php echo $list['role_name']; ?>
    </button>
    <ul class="dropdown-menu">
        <?/* if (isset($roles)): ?>
            <?php foreach ($roles as $rolesList): ?>
                <li>
                    <a href="/index.php?c=privs&priv_id=<?php echo $list['priv_id'] ?>&id_role=<?php echo $rolesList['role_id']; ?>"><?php echo $rolesList['role_name']; ?></a>
                </li>
            <?php endforeach; ?>
        <? endif; */ ?>
    </ul>
</div>

