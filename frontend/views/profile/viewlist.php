<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<span class="msg_response alert alert-danger" style="color:red; display: none; position: fixed; z-index: 9999999; right: 0px; top: 52px">

</span>

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">

            <div class="col-md-3 pag">
                <div class="">
                    <a href="<?= Url::toRoute('/profile/view/' . $user->username) ?>">
                        <img src="<?php
                        if(!$userView->photo){
                            echo '/avatars/noavatar.png';
                        }else{
                            echo '/avatars/'.$userView->photo;
                        }
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>
                    </a>
                    <div class="mag botto">
                        <span class="curs"> <?= $userView->username; ?></span>
                    </div>
                    <div class="mag botto">
                    <span class="curs"> <?= Yii::t('app', 'Уровень') ?>:
                        <span class="badge bmd-bg-primary rig"><?= $userView->level ?></span>
                    </span>
                    </div>
                    <div class="frend">
                        <div class="botto right-menu-active"><span class="curs"><a href="<?= Url::toRoute('/profile/viewlist?id=' . $userView->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Друзья') ?></span><span class="badge bmd-bg-info rig"><?php echo $friend_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/viewrequests?id=' . $userView->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/viewgiftlist?id=' . $userView->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
            </div>

            <div class="col-md-9 pag">

                <?php if($user_friends){ ?>
                    <?php foreach ($user_friends as $friend) { ?>

                        <div class="profile-list-friends">

                            <img class="profile-list-img" src="<?php if($friend->user->photo == null){
                                echo '/avatars/noavatar.png';
                            }else{
                                echo '/avatars/'.$friend->user->photo;
                            } ?>" alt="">

                            <a href="<?= Url::toRoute('/profile/view/' . $friend->user->username) ?>" class="profile-list-username"><?php echo $friend->user->first_name; ?> <?php echo $friend->user->last_name; ?> (<?= $friend->user->username; ?>)</a>

                            <span class="id" style="display: none;"><?= $friend->id; ?></span>

                            <div style="clear:both;"></div>
                        </div>

                    <?php } ?>

                <?php }else{ ?>
                    <?= Yii::t('app', 'Пока нет друзей') ?>
                <?php } ?>

            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>