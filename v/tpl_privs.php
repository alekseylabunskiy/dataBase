<div class="col-md-12  height90">
    <h2>Керування Привелегіями</h2>
</div>
<div class="col-md-12">
    <h2></h2>
</div>
<div>
    <div id="result">
        <table class="table table-bordered table-striped text-center" id="t_main">
            <thead>
            <tr>
                <th class="text-center">Прівелегія</th>
                <th class="text-center">Опис</th>
                <th class="text-center col-md-1">Роль</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($privsAndRoles)): ?>
                <?php foreach ($privsAndRoles as $list): ?>
                    <tr>
                        <td><?php echo $list['name']; ?></td>
                        <td><?php echo $list['description']; ?></td>
                        <td class="col-md-1">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle col-md-12"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <?php echo $list['role_name']; ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php if (isset($roles)): ?>
                                        <?php foreach ($roles as $rolesList): ?>
                                            <li><a class="new_role" href="/index.php?c=privs&priv_id=<?php echo $list['priv_id']?>&role_id=<?php echo $rolesList['role_id']; ?>"><?php echo $rolesList['role_name']; ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

