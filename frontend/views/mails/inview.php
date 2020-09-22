<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){

        $(".mail-post").click(function(){
            $('.msg_response').html('');
            var validate = $('.msg_response').hide();
            var subject = $("input[name=subject]").val();
            subject = $.trim(subject);
            var to = $("input[name=to]").val();
            to = $.trim(to);
            var message = $("textarea[name=message]").val();
            message = $.trim(message);
            var from = $(".from").text();
            from = $.trim(from);

            if(subject == "" || to == "" || message == "" || from == ""){
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
                        url: "<?= Url::toRoute('/mails/reply/') ?>",
                        type: "POST",
                        async: true,
                        data: {'subject': subject, 'to': to, 'message': message, 'from': from, 'type': 1}
                    }).done(function (result) {
                        if (result.status) {
                            validate.append(result.msg);
                            validate.css('color', 'rgb(0, 255, 101)');
                            validate.show();
                            $("textarea[name=message]").val('');
                        } else {
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
            <div class="faq_page_title mails_title"><?= Yii::t('app', 'Написать письмо') ?></div>
            <ul class="bonus_ul">
                <span class="from" style="display:none;"><?=\Yii::$app->user->identity->username; ?></span>

                <div class="col-md-5" style="padding-bottom: 20px;">

                    <?php if($mails){ ?>

                        <a href="<?= Url::toRoute('/mails/send/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Написать письмо') ?></a>
                        <a href="<?= Url::toRoute('/mails/in/') ?>" class="sup-add-menu sup-add-menu-active"><?= Yii::t('app', 'Входящие') ?> (<?= $inTotalCount ?>/<?= $inViewedCount ?>)</a>
                        <a href="<?= Url::toRoute('/mails/out/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Исходящие') ?> (<?= $outTotalCount ?>/<?= $outViewedCount ?>)</a>
                        <div style="clear:both"></div>

                        <?php foreach($mails as $mail){ ?>
                            <span class="mails-inview-title"><?= Yii::t('app', 'Дата') ?>:</span>
                            <span class="mails-inview-text"><?= $mail->date; ?></span>
                            <br>
                            <span class="mails-inview-title"><?= Yii::t('app', 'Логин отправителя') ?>:</span>
                            <span class="mails-inview-text"><?= $mail->from; ?></span>
                            <br>
                            <span class="mails-inview-title"><?= Yii::t('app', 'Тема') ?>:</span>
                            <span class="mails-inview-text"><?= $mail->subject; ?></span>
                            <br>
                            <span class="mails-inview-title"><?= Yii::t('app', 'Сообщение') ?>:</span>
                            <span class="mails-inview-message mails-inview-text"><?= $mail->message; ?></span>
                        <?php } ?>

                        <br><br>
                        <span class="msg_response" style="font-weight: bold; font-size: 17px;"></span>
                        <?php $form = \yii\widgets\ActiveForm::begin(); ?>

                        <span style="display: none"><?= $form->field($model, 'to')->textInput(['name' => 'to', 'value' => $mail->from]) ?></span>

                        <span style="display: none"><?= $form->field($model, 'subject')->textInput(['name' => 'subject', 'value' => $mail->subject]) ?></span>

                        <?= $form->field($model, 'message')->textArea(['rows' => '6', 'name' => 'message', 'placeholder' => Yii::t('app', 'Текст сообщения'), 'maxlength' => 500])->label(false); ?>

                        <?= \yii\helpers\Html::Button(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success mail-post']) ?>

                        <?php \yii\widgets\ActiveForm::end(); ?>

                    <?php }else{

                    } ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>

