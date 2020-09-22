<?php
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\Url;
?>

<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Обмен средств') ?></div>
            <ul class="news_ul">
                <?= \common\models\Settings::payExchangerText() ?>
                <br/>
                <br/>
                <strong>Сумма (Доступно: <span style="cursor: pointer; text-decoration: underline;" class="summ-available"> <?= $user->for_out ?></span>)</strong>
                <br/>
                <br/>
                <input style="color:black;" type="text" id="exchange-summ" name="exchange-summ">
                <br/>
                <br/>
                <a id="exchange" class="btn btn-success"><?= Yii::t('app', 'Обменять') ?></a>
            </ul>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        $('.summ-available').click(function(){
            $('#exchange-summ').html();
            var summ = $(this).text();
            $('#exchange-summ').val(summ);
            $('input[name="exchange-summ"]').val(summ);
        });

       $('#exchange').click(function () {
           var summ = $('#exchange-summ').val();
           $('#message').modal('hide');
           $('#site-close-button').removeClass('msg-close');

           if($.isNumeric(summ))
           {
               summ = Math.abs(summ);
               var summ_available = $('.summ-available').text();
               if(summ_available >= summ)
               {
                   $.ajax({
                       url: "<?= Url::toRoute('pay/do-exchange') ?>",
                       type: "POST",
                       async: true,
                       data: { summ: summ, '_csrf': "<?= Yii::$app->request->csrfToken ?>" }
                   }).done(function(response){
                       if(response.status)
                       {
                           $('.summ-available').text(response.for_out);
                           $('.response-answer').html(response.msg);
                           $('#message').modal('show');
                       }
                       else
                       {
                           $('.response-answer').html(response.msg);
                           $('#message').modal('show');
                       }
                   });
               }
               else
               {
                   var message = "<?= Yii::t('app', 'Недостачная сумма для перевода на счету') ?>";
                   $('.response-answer').html(message);
                   $('#message').modal('show');
               }
           }
           else
           {
               var message = "<?= Yii::t('app', 'Введите цифру') ?>";
               $('.response-answer').html(message);
               $('#message').modal('show');
           }
       })
    });
</script>
