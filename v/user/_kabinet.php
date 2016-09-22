<div class="col-md-12 text-left  height90">
    <h2>Змінити налаштування</h2>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-1">
        <div class="col-md-6">
            <label>Аватар</label>
            <img id="avatar_img" src="/v/files/user_avatar/originals/<?php if (!empty($one_person)) {
                echo $one_person['user_avatar'];
            } ?>" class="img-thumbnail" alt="Фото">
        </div>
    </div>
    <div class="col-lg-10 col-md-offset-1">
        <br>
        <form role="form" action="/index.php?c=user&a=view&id=<?php if (isset($one_person)) {
            echo $one_person['user_id'];
        } ?>" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" value="<?php if (isset($one_person)) {
                    echo $one_person['user_email'];
                } ?>" name="n_user_email"
                       id="u_email" placeholder="Введите Email">
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="text" class="form-control"  name="n_user_pass"
                       id="u_password" placeholder="Пароль">
                <p class="help-block"></p>
            </div>
            <button type="submit" id="confUserData" class="btn btn-success" name="u_send">Отправить</button>
        </form>
        <br>
    </div>
</div>
<div class="row">
    <div>
        <span class="col-md-offset-1"><button class="btn btn-info" type="button" data-toggle="collapse" data-target="#imageForm">Завантажити фото
            </button></span>
        <span><button class="btn btn-info" type="button" data-toggle="modal" data-target="#archiveImages">Завантажити фото з
                архіву
            </button></span>
    </div>
</div>
<br>
<br>
<div class="row">
    <div id="imageForm" class="collapse">
        <form class="col-md-offset-1" role="form" enctype="multipart/form-data"
              action="/index.php?c=user&a=single_user&id=<?php if (isset($one_person)) {
                  echo $one_person['user_id'];
              } ?>" method="post">
            <div class="form-group col-lg-3">
                <input id="foto_file" type="file" name="filename"/>
                <p class="help-block">Завантажувані фотографії повинні бути в форматі jpg,gif,png, і розміром не
                    більше 1Мб</p>
            </div>
            <div class="col-md-1">
                <button id="send_file" type="submit" data-toggle="modal" data-target="#myModal"
                        class="btn btn-success"
                        name="confirm_input_file">Завантажити
                </button>
            </div>
        </form>
    </div>
</div>
<br>
<div id="archiveImages" class="modal fade text-center">
    <div class="modal-dialog modal-lg oldOne">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Наявні фото</h4>
            </div>
            <div id="listImgs" class="modal-body mod_m">
                <div class="row">
                    <?php if (!empty($user_images) && !is_array($user_images)): ?>
                        <p class="center-block"><?php echo $user_images; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($user_images) && is_array($user_images)): ?>
                        <?php foreach ($user_images as $image): ?>
                            <div id="old_imgs" class="col-sm-4">
                                <div class="well">
                                    <a href="/index.php?c=user&a=single_user&id=<?php if (isset($one_person)) {
                                        echo $one_person['user_id'];
                                    } ?>&image_id=<?php echo $image['name_image']; ?>"><img id="old_i"
                                                                                            class="img img-responsive o_foto"
                                                                                            src="/v/files/user_avatar/originals/<?php echo $image['name_image']; ?>"></a>
                                    <br>
                                    <button type="button" class="btn btn-danger btn-block deleteImg">Видалити</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade text-center">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Попередження!</h4>
            </div>
            <div id="message" class="modal-body m_body"></div>
            <div class="modal-footer">
                <button class="btn btn-default m_mod" type="button" data-dismiss="modal">Закрити</button>
                <span id="not_add_foto" hidden="hidden"><button class="btn btn-danger" type="button"
                                                                data-dismiss="modal">Відхілити</button></span>
            </div>
        </div>
    </div>
</div>