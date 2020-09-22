<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){
        var element = $(this);
        $(".gift-add").click(function(){

            var id = $(this).closest('.gift-list').find(".id").text();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "<?= Url::toRoute('/profile/ajaxgift/') ?>",
                type: "POST",
                async:true,
                data: {'id': id, 'type': 1, '_csrf': csrfToken}
            }).done(function(result){
                if(result.addGift){
                    location.reload();
                }else{
                    var message = "<?= Yii::t('app', 'Ошибка') ?>";
                    alert(message);
                }
            });

        });

        $(".gift-remove").click(function(){

            var id = $(this).closest('.gift-list').find(".id").text();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "<?= Url::toRoute('/profile/ajaxgift/') ?>",
                type: "POST",
                async:true,
                data: {'id': id, 'type': 2, '_csrf': csrfToken}
            }).done(function(result){
                if(result.addGift){
                    location.reload();
                }else{
                    var message = "<?= Yii::t('app', 'Ошибка') ?>";
                    alert(message);
                }
            });

        });

    });
</script>

<span class="msg_response_success alert alert-success" style="color:green; display: none; position: fixed; z-index: 9999999; right: 0px; top: 52px"></span>
<span class="msg_response alert alert-danger" style="color:red; display: none; position: fixed; z-index: 9999999; right: 0px; top: 52px"></span>
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

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
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/requests/') ?>"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/message/index/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои Сообщения') ?></span><span class="badge bmd-bg-info rig"><?php echo $messageCount; ?></span></a></span></div>
                        <div class="botto right-menu-active"><span class="curs"><a href="/profile/giftlist/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
                    </div>
            </div>

            <div class="col-md-9 pag pag1">

                <p><?= Yii::t('app', 'Отправка подарка снимает 50 ед. энергии') ?></p>

                <div style="clear: both"></div>

                <h4><?= Yii::t('app', 'Мои полученные подарки') ?></h4>
                    <?php if($approvedGifts){ ?>
                        <?php foreach($approvedGifts as $aGift){ ?>
                            <div class="giftlist">
                                <div class="gift-list gift-approved-list">

                                    <img class="gift-list-img" src="/img/gifts/<?= $aGift->gifts->photo; ?>" alt="">
                                    <div style="clear: both"></div>

                                    <a href="<?= Url::toRoute('/profile/view/' . $aGift->from) ?>"><?= $aGift->from; ?></a>
                                    <div style="max-width: 105px"><p><?= $aGift->comment; ?></p></div>

                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        <?php } ?>

                    <?php }else{ ?>

                    <span style="color: red"><?= Yii::t('app', 'Вы еще не получили подарки') ?></span>

                <?php } ?>

                <div style="clear: both"></div>

                <h4><?= Yii::t('app', 'Мои отправленные подарки') ?></h4>
                <?php if($sendGifts){ ?>
                    <?php foreach($sendGifts as $sGift){ ?>

                        <div class="gift-list">

                            <img class="gift-list-img" src="/img/gifts/<?= $sGift->gifts->photo; ?>" alt="">
                            <div style="clear: both"></div>

                            <a href="<?= Url::toRoute('/profile/view/' . $sGift->to) ?>"><?= $sGift->to; ?></a>
                            <div style="max-width: 105px"><p><?= $sGift->comment; ?></p></div>
                        </div>

                    <?php } ?>
                <?php }else{ ?>

                <?php } ?>

            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
