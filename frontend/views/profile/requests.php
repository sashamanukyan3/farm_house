<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){

        $(".profile-list-add").click(function(){

            var id = $(this).next().next().text();
            var remove_object = $(this);

            $.ajax({
                url: "<?= Url::toRoute('/profile/friends/') ?>",
                type: "POST",
                async:true,
                data: {'id': id, 'type': 3}
            }).done(function(result){
                if(result.addFriends){
                    remove_object.closest('.request-container').fadeOut();
                }else{
                    var message = "<?= Yii::t('app', 'Ошибка') ?>";
                    alert(message);
                }
            });

        });

        $(".profile-list-remove").click(function(){

            var id = $(this).next().text();
            var remove_object = $(this);
            $.ajax({
                url: "<?= Url::toRoute('/profile/friends/') ?>",
                type: "POST",
                async:true,
                data: {'type': 2, 'id':id}
            }).done(function(result){
                if(result.removeFriends){
                    remove_object.closest('.request-container').fadeOut();
                }else{
                    var message = "<?= Yii::t('app', 'Ошибка') ?>";
                    alert(message);
                }
            });

        });

    });
</script>

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">

            <div class="col-md-3 pag">
                <div class="">
                    <a href="<?= Url::toRoute('/profile/index/') ?>">
                        <img src="<?php
                        if($user->photo == null){
                            echo '/avatars/noavatar.png';
                        }else{
                            echo '/avatars/'.$user->photo;
                        }
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>
                    </a>
                    <div class="mag botto">
                        <span class="curs"> <?= Yii::$app->user->identity->username; ?></span>
                    </div>
                    <div class="mag botto">
                    <span class="curs"> <?= Yii::t('app', 'Уровень') ?>:
                        <span class="badge bmd-bg-primary rig"><?= $user->level ?></span>
                    </span>
                    </div>
                    <div class="frend">
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/list/') ?>"><span style="color: #000"><?= Yii::t('app', 'Друзья') ?></span><span class="badge bmd-bg-info rig"><?php echo $friend_count; ?></span></a></span></div>
                        <div class="botto right-menu-active"><span class="curs"><a href="/profile/requests/"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/message/index/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои Сообщения') ?></span><span class="badge bmd-bg-info rig"><?php echo $messageCount; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/giftlist/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                </div>
                </div>
            </div>

            <div class="col-md-9 pag">

                <?php if($friends){ ?>
                    <?php foreach ($friends as $friend) { ?>

                        <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>

                        <div class="request-container">

                            <img class="profile-list-img" src="/avatars/<?php echo $friend->user->photo; ?>" alt="">

                            <a href="<?= Url::toRoute('/profile/view/' . $friend->user->username) ?>" class="profile-list-username"><?php echo $friend->user->first_name; ?> <?php echo $friend->user->last_name; ?> (<?= $friend->user->username; ?>)</a>
                            <br><br>
                            <a href="javascript:void(0);" class="profile-list-add">Добавить</a>
                            <a href="javascript:void(0);" class="profile-list-remove">Удалить</a>
                            <span class="id" style="display:none;"><?= $friend->id; ?></span>

                            <div style="clear:both;"></div>
                        </div>

                        <?php \yii\widgets\ActiveForm::end(); ?>

                    <?php } ?>
                <?php }else{ ?>
                    <?= Yii::t('app', 'У вас нет заявок') ?>
                <?php } ?>

            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>