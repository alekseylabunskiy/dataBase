<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">База данних користувачів</a>
        </div>
        <ul class="nav navbar-nav" id="mainNamvigation">
            <li><a href="/index.php?c=main&a=index">Користувачі</a></li>
            <?php if (isset($permissions)) {
                if (in_array('CAN_REDACT_USERS', $permissions)): ?>
                    <li><a href="/index.php?c=main&a=add_user">Додати користувача</a></li>
                <?php endif;
            } ?>
            <?php if (isset($permissions)) {
                if (in_array('CAN_REDACT_ROLES', $permissions)): ?>
                    <li><a href="/index.php?c=main&a=roles">Ролі</a></li>
                <?php endif;
            } ?>
            <?php if (isset($permissions)) {
                if (in_array('CAN_REDACT_PRIVS', $permissions)): ?>
                    <li><a href="/index.php?c=main&a=privs">Привілегії</a></li>
                <?php endif;
            } ?>
            <li><a href="/index.php?c=main&a=kabinet">Кабінет</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="" disabled><?php if (isset($user)) echo $user['user_name']; ?></a></li>
            <li><a href="/index.php?c=main&a=index&logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
        </ul>
    </div>
</nav>