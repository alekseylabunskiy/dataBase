<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($title)) {
            echo $title;
        } ?></title>
    <script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
    <script defer src="/v/js/bootstrap.min.js"></script>
    <script defer src="/v/js/formValidation.js"></script>
    <script defer src="/v/js/createUserFormValidation.js"></script>
    <script defer src="/v/js/functions.js"></script>
    <script defer src="/v/js/setUserStatus.js"></script>
    <script defer src="/v/js/setRoleToPriv.js"></script>
    <script defer src="/v/js/confirmDeleteRole.js"></script>
    <link rel="stylesheet" href="/v/css/bootstrap.min.css">
    <link rel="stylesheet" href="/v/css/style.css">
</head>
<body>
<?php if (!empty($currentUser)): ?>
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-sm-12 col-md-offset-1">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href=""><?php if (!empty($title)) {
                                echo $title;
                            } ?></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav" id="mainNamvigation">
                            <li><a href="/index.php?c=main_list">Користувачі</a></li>
                            <?php if (isset($permissions)) {
                                if (in_array('CAN_REDACT_USERS', $permissions)): ?>
                                    <li><a href="/index.php?c=add_user">Додати користувача</a></li>
                                <?php endif;
                            } ?>
                            <?php if (isset($permissions)) {
                                if (in_array('CAN_REDACT_ROLES', $permissions)): ?>
                                    <li><a href="/index.php?c=roles">Ролі</a></li>
                                <?php endif;
                            } ?>
                            <?php if (isset($permissions)) {
                                if (in_array('CAN_REDACT_PRIVS', $permissions)): ?>
                                    <li><a href="/index.php?c=privs">Привілегії</a></li>
                                <?php endif;
                            } ?>
                            <li><a href="/index.php?c=main_list&kabinet">Кабінет</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="" disabled><?php echo $currentUser; ?></a></li>
                            <li><a href="/index.php?c=main_list&logout">(Logout)</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <?php endif; ?>
            <?php if (!empty($content)): ?>
                <?php echo $content; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
