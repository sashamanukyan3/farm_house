<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){

        $(".gift-btn").click(function(){
            $('.msg_response').html('');
            var gifts_id = $("#gifts_id:checked").val();
            var from = $("#from").text();
            var to = $("#to").val();
                to = $.trim(to);
            var comment = $("#comment").val();
                comment = $.trim(comment);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            var validate = $('.msg_response').hide();

            var validate_success = $('.msg_response_success').hide();
                validate_success.empty();

            if(!to || !gifts_id){
                var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                validate.append(message);
                validate.css('color','red');
                validate.show();
            }else{
                $.ajax({
                    url: "<?= Url::toRoute('/profile/gift/') ?>",
                    type: "POST",
                    async:true,
                    data: {'gifts_id': gifts_id, 'from': from, 'to': to, 'comment': comment, '_csrf': csrfToken}
                }).done(function(result){
                    if(result.gift){
                        validate_success.append(result.msg);
                        validate_success.css('color','green');
                        validate_success.show();

                        $("#comment").val('');
                        $("#to").val('');
                        $("input:radio").removeAttr('checked');
                    }else{
                        validate.css('color','red');
                        validate.append(result.msg);
                        validate.show();
                    }
                });
            }

        });

    });
</script>

<span class="msg_response_success alert alert-success" style="color:green; display: none; position: fixed; z-index: 9999999; left: 0px; top: 52px"></span>
<span class="msg_response alert alert-danger" style="color:red; display: none; position: fixed; z-index: 9999999; left: 0px; top: 52px"></span>
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
                        ?>" alt="Картинка" class="imgsize" type="button" class="btn btn-primary bmd-ripple" data-bmd-state="primary"  data-placement="bottom" title=""/>
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
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/giftlist/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
                    </div>
            </div>

            <div class="col-md-9 pag">

                <p><?= Yii::t('app', 'Отправка подарка снимает {energyUnits} ед Энергии. Цена подарка указана под ним.', [
                    'energyUnits' => \common\models\Settings::$giftEnergyText,
                ]) ?></p>

                <?php if($gifts){ ?>
                    <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>

                    <div class="search-input">
                        <p style="font-weight: bold"><?= Yii::t('app', 'Кому') ?>:</p>
                        <?php if($_GET){ ?>
                            <?php $username = $_GET['username']; ?>
                            <input type="text" class="form-control" id="to" value="<?= $username; ?>" maxlength="75" placeholder="<?= Yii::t('app', 'Кому') ?>">
                        <?php }else{ ?>
                            <input type="text" class="form-control" id="to" maxlength="75" placeholder="<?= Yii::t('app', 'Кому') ?>">
                        <?php } ?>
                    </div>

                    <br>
                    <p style="font-weight: bold"><?= Yii::t('app', 'Выберите подарок') ?>:</p>
                    <?php foreach($gifts as $gift){ ?>

                        <div class="gift-list">

                            <img class="gift-list-img" src="/img/gifts/<?= $gift->photo; ?>" alt="">
                            <div style="clear: both"></div>

                            <?= $form->field($model, 'gifts_id')->radio(['value' => $gift->id, 'id' => 'gifts_id', 'label' => ''])->label(false) ?>

                            <span class="gift-price" style="float: left; margin-top: -20px;"><?php echo \common\models\Settings::$giftEnergyText; ?> <?= Yii::t('app', 'ед.') ?></span>

                            <div style="clear:both;"></div>
                        </div>

                    <?php } ?>

                    <div style="clear: both"></div>

                    <input type="text" class="form-control gift-input" id="comment" name="" maxlength="50" placeholder="<?= Yii::t('app', 'Можете написать пару слов (до 50 символов)') ?>">
                    <?= Html::button(Yii::t('app', 'Подарить'), [ 'class' => 'gift-btn btn btn-primary']); ?>

                    <span id="from" style="display: none"><?= \Yii::$app->user->identity->username; ?></span>
                    <?php \yii\widgets\ActiveForm::end(); ?>

                <?php }else{ ?>

                    <?= Yii::t('app', 'Ничего не найдено') ?>

                <?php } ?>

            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
