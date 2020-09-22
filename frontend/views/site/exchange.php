<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
?>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Биржа опыта') ?></div>
                <?php if($status) : ?>
                <div class="bonus-add">
                    <ul class="news_ul">
                    <?= \common\models\Settings::getExchangeText($exchange->alias); ?>
                    <br>
                    <?php $alias = $exchange->alias; ?>
                    <p><?= Yii::t('app', 'У вас в наличии {units} ед.', [
                        'units' => $userStorage->$alias,
                    ]) ?></p>
                    <p><?= Yii::t('app', 'Курс обмена:  продукт и {energyUnits} энергии = {experienceUnits} опыта.', [
                        'energyUnits' => $exchange->energy,
                        'experienceUnits' => $exchange->experience,
                    ]) ?></p>
                    <h3><?= Yii::t('app', 'Обменять продукты на опыт') ?></h3>
                    <p><b><?= Yii::t('app', 'Минимальная ставка') ?>: <span class="min-count"><?= $exchange->count; ?></span></b></p>
                    <p><b><?= Yii::t('app', 'Снимется энергии') ?>: </b><?= $exchange->energy; ?></p>
                    <p><b><?= Yii::t('app', 'Получение опыта') ?>: </b><?= $exchange->experience; ?></p>
                    <br>
                        <input style="color:black; padding: 3px;" id="product-count" type="text" placeholder="<?= Yii::t('app', 'Количество') ?>" />
                    <br>
                    <br>
                        <input class="exchange btn btn-primary" name="post" type="submit" value="<?= Yii::t('app', 'Обменять') ?>" />
                    <?php else: ?>
                        <?= \common\models\Settings::bonusDisabled(); ?>
                    <?php endif; ?>
                        </ul>
                </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
          IS_SENT = true;
          $('.exchange').click(function()
          {
              if (!IS_SENT) {
                  return 1;
              }
              else {
                  IS_SENT = false;
              }
//              $('#site-close-button').removeClass('msg-close');
              var product_count = parseInt($('#product-count').val());

              var min_count     = parseInt($('.min-count').html());
              if(product_count < min_count)
              {
                  var message = "<?= Yii::t('app', 'Минимальная ставка обмена') ?>";
                  $('.response-answer').html(message + ' ' + min_count);
                  $('#message').modal('show');
                  IS_SENT = true;
                  return 1;
              }
              if(product_count%min_count != 0)
              {
                  var message = "<?= Yii::t('app', 'Количество должно быть кратным для') ?>";
                  $('.response-answer').html(message + ' ' + min_count);
                  $('#message').modal('show');
                  IS_SENT = true;
                  return 1;
              }
              $.ajax({
                  url: "<?= Url::toRoute('/site/get-exchange') ?>",
                  type: "POST",
                  async: true,
                  data: { product_count: product_count, '_csrf': "<?= Yii::$app->request->csrfToken ?>"}
              }).done(function (response) {
                  $('.response-answer').empty();
                  if (response.status) {
                      if(response.is_level)
                      {
                          response.msg += '<h4>';
                          response.msg += "<?= mb_strtoupper(Yii::t('app', 'Вы достигли')) ?>";
                          response.msg += " ";
                          response.msg += response.newLevel;
                          response.msg += " ";
                          response.msg += "<?= mb_strtoupper(Yii::t('app', 'Уровня')) ?>";
                          response.msg += '!!!';
                          response.msg+='</h4>';
                          $('#user_lvl').html(response.newLevel);
                      }
                      $('#product-count').val('');
                      $('.response-answer').html(response.msg);
                      $('#message').modal('show')
                  } else {
                      $('.response-answer').html(response.msg);
                      $('#message').modal('show')
                  }

              });
              IS_SENT = true;
              return 1;
          })
    })
</script>
