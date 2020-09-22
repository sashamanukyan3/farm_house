<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
?>

<script>
    $(document).ready(function(){

        var sup_id = $(".sup_id").text();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "<?= Url::toRoute('/support/viewed/') ?>",
            type: "POST",
            async:true,
            data: {'sup_id': sup_id, '_csrf': csrfToken}
        }).done(function(result){
            if(result.supViewed){

            }
        });

    });
</script>
<span class="sup_id" style="display:none;"><?php echo $_GET["id"]; ?></span>
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title">Тех. Поддержка') ?></div>
            <ul class="bonus_ul">
                <a href="<?= Url::toRoute('/support/send/') ?>" class="sup-add-menu">Создать тикет') ?></a>
                <a href="<?= Url::toRoute('/support/out/') ?>" class="sup-add-menu sup-add-menu-active">Ваши тикеты') ?></a>

                <?php if($support){ ?>
                    <?php foreach($support as $list){ ?>

                        <div class="sup-view">
                            <div class="col-md-12">
                                <p><b><?= Yii::t('app', 'Логин') ?>: </b><?= $list->userreply->username; ?></p>
                                <p><b><?= Yii::t('app', 'Название') ?>: </b><?= $list->subject; ?></p>
                                <p><b><?= Yii::t('app', 'Сообщение') ?>: </b><?= $list->message; ?></p>
                                <p><b><?= Yii::t('app', 'Дата') ?>: </b><?= date("Y-m-d H:i:s", $list->date); ?></p>
                            </div>
                        </div>

                        <div class="sup-view-reply">
                            <?php if($supportReplyList){ ?>
                                <br>
                                <p style="font-size: 17px; font-weight: bold; margin: 10px"><?= Yii::t('app', 'Ответы') ?></p>
                                <?php foreach($supportReplyList as $reply): ?>
                                    <div class="col-md-12" style="border-bottom: 1px dashed #ddd; margin-bottom: 20px;">
                                        <?php
                                            if($reply->from == Yii::$app->user->identity->id){
                                                echo '<p><b>' . Yii::t('app', 'Логин') . ': </b>'.Yii::$app->user->identity->username.'</p>';
                                            }else{
                                                echo '<p><b>' . Yii::t('app', 'Логин') . ': </b>'.$list->user->username.'</p>';
                                            }
                                        ?>
                                        <p class="sup-list-text"><b><?= Yii::t('app', 'Сообщение') ?>: </b><?= $reply->message ?></p>
                                        <p class="sup-list-text"><b><?= Yii::t('app', 'Дата') ?>: </b><?= date("Y-m-d H:i:s", $reply->date) ?></p>
                                    </div>

                                <?php endforeach; ?>

                                <div class="col-md-6" style="display: <?php echo ($list->status == 2 ? 'none' : 'block') ?>">
                                    <br>
                                    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

                                    <?= $form->field($model, 'message')->textArea(['rows' => '6', 'name' => 'message', 'maxlength' => 1500]) ?>

                                    <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success']) ?>

                                    <?php \yii\widgets\ActiveForm::end(); ?>
                                </div>

                            <?php }else{ ?>
                                <span class="msg_response" style="color:red; font-weight: bold;"><?= Yii::t('app', 'Ответа пока нет') ?></span>
                            <?php } ?>
                        </div>

                    <?php } ?>
                <?php } ?>

            </ul>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>