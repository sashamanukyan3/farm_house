<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">

            <div class="col-md-3 pag">
                <div class="">
                    <a href="<?= Url::toRoute('/profile/index/') ?>">

                       <?php if(\Yii::$app->user->identity->photo){ ?>
                           <img src="/avatars/<?= \Yii::$app->user->identity->photo; ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>
                       <?php } else{ ?>
                           <img src="/avatars/noavatar.png" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>
                       <?php } ?>

                    </a>
                    <div class="mag botto">
                        <span class="curs"> <?= Yii::$app->user->identity->username; ?></span>
                    </div>
                    <div class="mag botto">
                    <span class="curs"> <?= Yii::t('app', 'Уровень') ?>:
                        <span class="badge bmd-bg-primary rig"><?= $user->level; ?></span>
                    </span>
                    </div>
                    <div class="frend">
                        <div class="botto right-menu-active"><span class="curs"><a href="<?= Url::toRoute('/profile/list/') ?>"><span style="color: #000"><?= Yii::t('app', 'Друзья') ?></span><span class="badge bmd-bg-info rig"><?php echo $friend_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/requests/') ?>"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div>
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

                <?php if($userList == "" or $query == ""){?>

                    <?= Yii::t('app', 'Не заполнена форма поиска') ?>

                <?php }else{
                    if(!empty($userList) && empty($msg)){
                    foreach($userList as $user){?>

                        <div class="profile-list-friends">

                            <img class="profile-list-img" src="/avatars/<?php echo $user->photo; ?>" alt="">

                            <a href="<?= Url::toRoute('/profile/view/' . $user->username) ?>" class="profile-list-username"><?= $user->username?></a>

                            <span class="id" style="display: none;"><?= $user->id; ?></span>

                            <div style="clear:both;"></div>
                        </div>

                    <?php } ?>

                <?php } else {
                    echo '<h4>'.$msg.'</h4>';
                } }?>

            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>