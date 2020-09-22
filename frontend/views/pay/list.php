<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<?php if($msg): ?>
    <script>
        $(document).ready(function()
        {
            $('#site-close-button').removeClass('msg-close');
            $('.response-answer').html("<?= $msg?>");
            $('#message').modal('show');
        });
    </script>
<?php endif; ?>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Список платежных систем') ?></div>
            <ul class="news_ul">
                <blockquote class="bmd-border-primary news-view-div">

                    <p class="faq_title"><span href=""></span></p>
                    <div class="faq_content news-content-div">
                        <center>
                        <a target="_blank" style="margin-right: 5px;"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/payeer.png" width="150" height="66" border="0"></a>
                        <a target="_blank" style="margin-right: 5px;"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/logomail.png" width="150" height="66" border="0"></a>
                        <a target="_blank" style="margin-right: 5px;"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/ya.png" width="150" height="66" border="0"></a>
                        <a target="_blank" style="margin-right: 5px;"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/qw_logo.png" width="150" height="66" border="0"></a>
                        <a target="_blank" style="margin-right: 5px;"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/mykassa.png" width="150" height="66" border="0"></a>
                        </center>
                        <br/>
                        <?= Yii::t('app', 'Для пополнения баланса доступно пять платёжных систем. С их помощью, Вы можете пополнить ваш баланс с разных платёжных систем: QiWi, Яндекс.Деньги, WebMoney, Perfect Money, Payeer, VISA, MasterCard, МТС, Мегафон, Билайн, Сбербанк, Альфа-Банк, Bitcoin, Ooopay и другие. После оплаты, сумма будет добавлена к вашему балансу автоматически.') ?><br/>
                        <br/>
                        <center> <a target="_blank"><img src="<?= Yii::$app->getUrlManager()->baseUrl?>/img/pay/web.png" width="150" height="66" border="0"></a></center>

                        <br/><br>

                        <span style="color:red; font-weight: bold; font-size: 18px;"></span><br/><br/>

						<br/><br>
						
                        <span style="font-size: 25px; font-weight: bold;"><?= Yii::t('app', 'Форма пополнения баланса') ?>: </span>
                        <span style="color:red"><?= Yii::$app->session->getFlash('pay_err'); ?></span>
                        <?php $form = ActiveForm::begin(['id' => 'pay-form', 'action' => \yii\helpers\Url::toRoute('/pay/send')]); ?>

                        <?= $form->field($payForm, 'sum')->textInput(['maxlength' => true,'type' => 'text','size'=>15, 'style'=>'width:25%']) ?>

                        <?= $form->field($payForm, 'pay_type')->dropDownList([
                                '1' => 'QIWI',
                                '2' => 'Payeer.com',
                                '3' => 'freekassa.com',
                                '4' => 'Yandex.Деньги',
                                '5' => 'mykassa',
                                ],
                                [
                                'prompt' => Yii::t('app', 'Выберите один вариант'),
                                'style'=>'width:25%',
                                ]);
                        ?>
                        <div class="form-group">
                            <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Пополнить'), ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                <div style="clear:both;"></div>

                </blockquote>
            </ul>
        </div>
    </div>
</div>
