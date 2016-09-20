<?php if (isset($text)): ?>
    <div class="panel panel-default text-center marg">
        <div class="panel-body">
            <div class="alert alert-danger" role="alert"><h1><?php echo $text; ?></h1></div>
        </div>
    </div>
    <div class="panel panel-default text-center">
        <div class="panel-body">
            <a href="/index.php?c=main&a=login"><h3>Перейти на сторінку авторізації</h3></a>
        </div>
    </div>
<?php endif; ?>
