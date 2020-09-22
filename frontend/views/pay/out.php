<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Вывод баланса') ?></div>
            <ul class="news_ul">
                <blockquote class="bmd-border-primary news-view-div">
                    <p>
                        <?= Yii::t('app', 'Комиссия за вывод средств зависит от суммы вывода (не меньше 1.00 руб.)') ?><br>
                        <?= Yii::t('app', 'Сумма от 1.00 руб до 9.99 руб - комиссия 5%') ?><br>
                        <?= Yii::t('app', 'Сумма от 10.00 руб до 99.99 руб - комиссия 2%') ?><br>
                        <?= Yii::t('app', 'Сумма от 100.00 руб до 999.99 руб - комиссия 1%') ?><br>
                        <?= Yii::t('app', 'Сумма от 1000.00 руб и выше - комиссия 0%') ?><p>
                        <br>
                        <?= Yii::t('app', 'При выводе средств снимается энергия, за каждые 10 руб 1 ед энергии. Минимум - 1 ед энергии.') ?><br>
                        <font color="#FC0202"><?= Yii::t('app', 'Внимание! При заказе выплат на Qiwi указывайте свой кошелёк верно! В формате +ХХХХХХХХХХ, не нужно просто печатать свой номер телефона! Выплаты с несоответствующими номерами будут отменены. При отмене деньги вернутся на баланс для оплаты.') ?></font><br>
                        <span style="color:red"><?= Yii::$app->session->getFlash('pay_err'); ?></span>
                        <?php //var_dump($user->pay_pass_date); die; ?>
                        <?php if($user->pay_pass_date == 0 || ($user->pay_pass_date < strtotime('7 day ago'))): ?>
                            <?php if(!empty($msg)){?><span style="color:red"><?=$msg; ?></span><?php } ?><br>
                            <?php if((is_object($lastMyPayOut) && ($lastMyPayOut->created_at < strtotime('24 hour ago'))) || is_null($lastMyPayOut)) {?>
                                <span style="font-size: 17.5px;"><?= Yii::t('app', 'Доступная сумма') ?>: <?= $user->for_out?></span>
                                <?php $form = ActiveForm::begin(['id' => 'pay-form', 'action' => \yii\helpers\Url::toRoute('/pay/send-out')]); ?>

                                <?= $form->field($payOutForm, 'sum')->textInput(['maxlength' => true, 'min'=>1, 'type' => 'number','size'=>15, 'style'=>'width:25%']) ?>

                                <?= $form->field($payOutForm, 'pay_type')->dropDownList([
                                    'Payeer' => 'Payeer',
                                    'QIWI'   => 'QIWI',
                                    'WebMoney'=>'WebMoney',
                                    'Яндекс.Деньги'=>'Яндекс.Деньги',
                                    'Мегафон(РОССИЯ)'=>'Мегафон(РОССИЯ)',
                                    'Билайн(РОССИЯ)' => 'Билайн(РОССИЯ)',
                                    'МТС(РОССИЯ)' => 'МТС(РОССИЯ)',
                                ],
                                    [
                                        'prompt' => Yii::t('app', 'Выберите один вариант'),
                                        'style'=>'width:25%',
                                    ]);
                                ?>

                                <?= $form->field($payOutForm, 'purse')->textInput(['maxlength' => true,'type' => 'text','size'=>15, 'style'=>'width:25%']) ?>
                                <?= $form->field($payOutForm, 'pay_pass')->textInput(['maxlength' => true, 'autocomplete'=>'off', 'type' => 'text','size'=>15, 'style'=>'width:25%']) ?>

                                <div class="form-group">
                                    <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Отправить запрос'), ['class' => 'btn btn-success']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            <?php } else {?>
                                <span style="color:red"><?= Yii::t('app', 'Вы не можете выводить средства чаще чем 1 раз в сутки') ?></span>
                            <?php }?>
                        <?php else: ?>
                            <span style="color:red"><?= Yii::t('app', 'Перевод средств доступен только после активации платежного пароля (Платежный пароль будет активен только через 7 дней после смены платежного пароля)') ?></span>
                        <?php endif;?>
                    <br><p><?= Yii::t('app', 'Последние 10 выплат. ВНИМАНИЕ! При отмене выплаты, деньги вернутся на баланс для оплаты!') ?></p><br>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <tr >
                            <th><?= Yii::t('app', 'Сумма (руб)') ?></th>
                            <th><?= Yii::t('app', 'Дата') ?></th>
                            <th><?= Yii::t('app', 'Система') ?></th>
                            <th><?= Yii::t('app', 'Кошелек') ?></th>
                            <th><?= Yii::t('app', 'Статус') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($payOutList as $history) : ?>
                            <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                            <tr class="<?= $class;?>">
                                <td><?=$history->amount; ?></td>
                                <td><?=date('Y-m-d H:i:s', $history->created_at); ?></td>
                                <td><?=$history->pay_type; ?></td>
                                <td><?=$history->purse; ?></td>
                                <?php if($history->status_id == 1) : ?>
                                    <td><button type="button" class="btn btn-danger cancel" data-id="<?=$history->id?>">Отменить вывод</button></td>
                                <?php elseif($history->status_id == 2): ?>
                                    <td><?= Yii::t('app', 'Завершен') ?></td>
                                <?php else :?>
                                    <td><?= Yii::t('app', 'Отменен') ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                    <div style="clear:both;"></div>

                </blockquote>
            </ul>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
<script>
    $(document).ready(function() {

        DISABLED_CANCEL = true;

        $('.cancel').click(function () {
            if (!DISABLED_CANCEL) {
                return 1;
            }
            else {
                DISABLED_CANCEL = false;
            }
            var id = $(this).data('id');
            if (id) {
                DISABLED_CANCEL = true;
                $.ajax({
                    url: "<?= Url::toRoute('/pay/cancel/') ?>",
                    type: "POST",
                    async: true,
                    data: {'id': id, '_csrf': "<?= Yii::$app->request->csrfToken ?>"}
                }).done(function (response) {
                    if (response.status) {
                        $('.response-answer').html(response.msg);
                        $('#message').modal('show');
                    } else {
                        $('.response-answer').html(response.msg);
                        $('#message').modal('show');
                    }
                });
            }
            else {

            }
            DISABLED_CANCEL = true;
            return 1;
        });
    })
</script>
