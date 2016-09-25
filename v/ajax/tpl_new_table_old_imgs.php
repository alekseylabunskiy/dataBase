<div class="modal-dialog modal-lg newOne">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <h4 class="modal-title">Наявні фото</h4>
        </div>
        <div id="listImgs" class="modal-body">
            <div class="row">
                <?php if (!empty($user_images) && !is_array($user_images)): ?>
                    <p class="center-block"><?php echo $user_images; ?></p>
                <?php endif; ?>
                <?php if (!empty($user_images) && is_array($user_images)): ?>
                    <?php foreach ($user_images as $image): ?>
                        <div id="old_imgs" class="col-sm-4">
                            <div class="well">
                                <a href="/index.php?c=main&a=update_foto&id=<?php if (isset($one_person)) {
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