<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">База данних користувачів</a>
        </div>
        <ul class="nav navbar-nav" id="mainNamvigation">
            <li><a href="/index.php?c=user&a=index">Користувачі</a></li>
            <?php if (isset($permissions)): ?>
                <?php   if (in_array('USER_CREATE', $permissions)): ?>
                    <li><a href="/index.php?c=user&a=create">Додати користувача</a></li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($permissions)): ?>
                <?php if (in_array('ROLE_INDEX', $permissions)): ?>
                    <li><a href="/index.php?c=role&a=index">Ролі</a></li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($permissions)): ?>
                <?php if (in_array('PRIV_INDEX', $permissions)): ?>
                    <li><a href="/index.php?c=priv&a=index">Привілегії</a></li>
                <?php endif; ?>
            <?php endif; ?>
            <li><a href="/index.php?c=user&a=update&kab">Кабінет</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="" disabled><?php if (isset($user)) echo $user['user_name']; ?></a></li>
            <li><a href="/index.php?c=login&a=logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
        </ul>
    </div>
</nav>