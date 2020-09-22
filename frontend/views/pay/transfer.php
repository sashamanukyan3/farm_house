<?php
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\Url;
?>

<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Перевод средств') ?></div>
            <ul class="news_ul">
                <?= \common\models\Settings::payTransferText() ?>
                <br/>
                <strong><?= Yii::t('app', 'Комиссия системы за перевод составляет {percent}%', [
                    'percent' => \common\models\Settings::$transferProcent,
                ]) ?></strong>
                <br/>
                <br/>
                <?php if($user->pay_pass_date == 0 || $user->pay_pass_date < strtotime('7 day ago')): ?>
                    <input style="color:black; padding: 3px;" type="text" id="transfer-user-login" placeholder="<?= Yii::t('app', 'Пользователь') ?>">
                    <br/>
                    <br/>
                    <input style="color:black; padding: 3px;" type="text" id="transfer-user-summ" placeholder="<?= Yii::t('app', 'Сумма') ?>">
                    <br/>
                    <br/>
                    <input style="color:black; padding: 3px;" type="text" id="transfer-pay-pass" placeholder="<?= Yii::t('app', 'Платежный пароль') ?>">
                    <br/>
                    <br/>
                    <a id="exchange" class="btn btn-success"><?= Yii::t('app', 'Перевести') ?></a>
                <?php else : ?>
                    <span style="color:red;"> <?= Yii::t('app', 'Перевод средств доступен только после активации платежного пароля (Платежный пароль будет активен только через 7 дней после смены платежного пароля).') ?></span>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
       $('#exchange').click(function () {
           var username = $('#transfer-user-login').val();
           var summ = $('#transfer-user-summ').val();
           var pay_pass = $('#transfer-pay-pass').val();
           $('#message').modal('hide');
           $('#site-close-button').removeClass('msg-close');

           if($.isNumeric(summ))
           {
               summ = Math.abs(summ);
                   $.ajax({
                       url: "<?= Url::toRoute('pay/do-transfer') ?>",
                       type: "POST",
                       async: true,
                       data: { summ: summ, username:username, pay_pass:pay_pass, '_csrf': "<?= Yii::$app->request->csrfToken ?>" }
                   }).done(function(response){
                            if(response.status)
                            {
                                $('#transfer-user-login').val('');
                                $('#transfer-user-summ').val('');
                                $('#transfer-pay-pass').val('');
                            }
                           $('.response-answer').html(response.msg);
                           $('#message').modal('show');
                   });
           }
           else
           {
               $('.response-answer').html('Введите цифру');
               $('#message').modal('show');
           }
       })
    });
</script>
