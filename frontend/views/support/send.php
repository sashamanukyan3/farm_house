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

        $(".mail-post").click(function(){
            var validate = $('.msg_response').hide();
            var subject = $("input[name=subject]").val();
            subject = $.trim(subject);
            var message = $("textarea[name=message]").val();
            message = $.trim(message);

            if(subject == "" || message == ""){
                $('.msg_response').html('');
                var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                validate.append(message);
                validate.css('color','red');
                validate.show();
            }else{

                var findRU = message.indexOf(".ru");
                var findCOM = message.indexOf(".com");
                var findNET = message.indexOf(".net");
                var findORG = message.indexOf(".org");
                var findHTTP = message.indexOf("http://");
                var findHTTPS = message.indexOf("https://");
                var findWWW = message.indexOf("www.");

                if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

//                    alert('В тексты не должны быть ссылки!');

                }else {

                    $.ajax({
                        url: "<?= Url::toRoute('/support/send/') ?>",
                        type: "POST",
                        async: true,
                        data: {'subject': subject, 'message': message}
                    }).done(function (result) {
                        if (result.status) {
                            $('.msg_response').html('');
                            validate.append(result.msg);
                            validate.css('color', 'rgb(0, 255, 101)');
                            validate.show();
                            $("input[name=subject]").val('');
                            $("input[name=to]").val('');
                            $("textarea[name=message]").val('');
                        } else {
                            $('.msg_response').html('');
                            validate.css('color', 'red');
                            validate.append(result.msg);
                            validate.show();
                        }
                    });

                }

            }

        });

    });
</script>

<div class="bmd-page-container padd">
    <div class="container">

        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Тех. Поддержка') ?></div>
            <ul class="bonus_ul">

                <div class="col-md-5" style="padding-bottom: 20px;">

                    <a href="<?= Url::toRoute('/support/send/') ?>" class="sup-add-menu sup-add-menu-active"><?= Yii::t('app', 'Создать тикет') ?></a>
                    <a href="<?= Url::toRoute('/support/out/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Ваши тикеты') ?></a>

                    <br>
                    <span class="msg_response" style="color: red"></span>
                    <span class="user_id" style="display: none"><?= \Yii::$app->user->identity->id; ?></span>

                    <div style="clear: both"></div>
                    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

                    <?= $form->field($model, 'subject')->textInput(['name' => 'subject']) ?>

                    <?= $form->field($model, 'message')->textArea(['rows' => '6', 'name' => 'message', 'maxlength' => 1500]) ?>

                    <?= \yii\helpers\Html::Button(Yii::t('app', 'Создать тикет'), ['class' => 'btn btn-success mail-post']) ?>

                    <?php \yii\widgets\ActiveForm::end(); ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>