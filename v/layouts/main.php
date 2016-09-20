<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($title)) { echo $title; } ?></title>
    <script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
    <script defer src="/v/js/bootstrap.min.js"></script>
    <script defer src="/v/js/jquery.colorbox-min.js"></script>
    <script defer src="/v/js/formValidation.js"></script>
    <script defer src="/v/js/createUserFormValidation.js"></script>
    <script defer src="/v/js/functions.js"></script>
    <script defer src="/v/js/setUserStatus.js"></script>
    <script defer src="/v/js/setRoleToPriv.js"></script>
    <script defer src="/v/js/confirmDeleteRole.js"></script>
    <script defer src="/v/js/Fotos.js"></script>
    <link rel="stylesheet" href="/v/css/bootstrap.min.css">
    <link rel="stylesheet" href="/v/css/style.css">
    <link rel="stylesheet" href="/v/css/colorbox.css">
</head>
<body>
    <div class="container">
        <?php if(isset($user) && $user != null): ?>
            <?php include_once 'nav_bar.php';?>
        <?php endif; ?>
        <?php if (!empty($content)): ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </div>
</body>
</html>