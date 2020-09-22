<?php

use yii\helpers\Url;

?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'История вывода средств') ?></h4>
            <hr>
            <p><a href="<?= Url::toRoute('/profile/login-history') ?>"><?= Yii::t('app', 'Вход в аккаунт') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/in-history') ?>"><?= Yii::t('app', 'Пополнение баланса') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/transfer-history') ?>"><?= Yii::t('app', 'Переводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/exchange-history') ?>"><?= Yii::t('app', 'Обмены средств') ?></a></p>
            <p><a href="#" style="font-weight: bold;"><?= Yii::t('app', 'Выводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/history') ?>"><?= Yii::t('app', 'Партнёрская программа') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/my-history') ?>"><?= Yii::t('app', 'Покупка животных, корма и загонов') ?></a></p>
            <span><?= Yii::t('app', 'Всего выведено на сумму') ?>: <?= ($allSum) ? $allSum : 0; ?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?>.</span>
            <table class="table table-striped table-hover ">
                <thead>
                <tr >
                    <th><?= Yii::t('app', 'Сумма(руб.)') ?></th>
                    <th><?= Yii::t('app', 'Дата') ?></th>
                    <th><?= Yii::t('app', 'Система') ?></th>
                    <th><?= Yii::t('app', 'Кошелек') ?></th>
                    <th><?= Yii::t('app', 'Статус') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($payOut as $history) : ?>
                    <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                    <tr class="<?= $class;?>">
                        <td><?=$history->amount; ?></td>
                        <td><?=date('Y-m-d H:i:s', $history->created_at); ?></td>
                        <td><?=$history->pay_type; ?></td>
                        <td><?=$history->purse; ?></td>
                        <?php if($history->status_id == 1) : ?>
                            <td><?= Yii::t('app', 'В обработке') ?></td>
                        <?php elseif($history->status_id == 2) : ?>
                            <td><?= Yii::t('app', 'Завершен') ?></td>
                        <?php else: ?>
                            <td><?= Yii::t('app', 'Отменен') ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>