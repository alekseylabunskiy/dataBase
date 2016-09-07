<?php if (isset($_SESSION['wrong_auth'])): ?>
    <div class="panel panel-default text-center marg">
        <div class="panel-body">
            <div class="alert alert-danger" role="alert"><h1><?php echo $_SESSION['wrong_auth']; ?></h1></div>
        </div>
    </div>
    <div class="panel panel-default text-center">
        <div class="panel-body">
            <a href="/index.php?c=login"><h3>Перейти на сторінку авторізації</h3></a>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['wrong_url'])): ?>
    <div class="panel panel-default text-center marg">
        <div class="panel-body">
            <div class="alert alert-danger" role="alert"><h1><?php echo $_SESSION['wrong_url']; ?></h1></div>
        </div>
    </div>
    <div class="panel panel-default text-center">
        <div class="panel-body">
            <a href="/index.php?c=login"><h3>Перейти на сторінку авторізації</h3></a>
        </div>
    </div>
<?php endif; ?>
