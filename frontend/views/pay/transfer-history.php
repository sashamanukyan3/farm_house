<?php

use yii\helpers\Url;

?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'История перевода средств') ?></h4>
            <hr>
            <p><a href="<?= Url::toRoute('/profile/login-history') ?>"><?= Yii::t('app', 'Вход в аккаунт') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/in-history') ?>"><?= Yii::t('app', 'Пополнение баланса') ?></a></p>
            <p><a href="#" style="font-weight: bold;"><?= Yii::t('app', 'Переводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/exchange-history') ?>"><?= Yii::t('app', 'Обмены средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/out-history') ?>"><?= Yii::t('app', 'Выводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/history') ?>"><?= Yii::t('app', 'Партнёрская программа') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/my-history') ?>"><?= Yii::t('app', 'Покупка животных, корма и загонов') ?></a></p>
            <span><?= Yii::t('app', 'Всего переведено на сумму') ?>: <?= ($allSum) ? $allSum : 0?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?>.</span>
            <table class="table table-striped table-hover ">
                <thead>
                <tr >
                    <th><?= Yii::t('app', 'Кому') ?></th>
                    <th><?= Yii::t('app', 'Сумма') ?></th>
                    <th><?= Yii::t('app', 'Дата') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if($transferHistory): ?>
                    <?php $i=1; foreach($transferHistory as $history) : ?>
                        <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                        <tr class="<?= $class;?>">
                            <td><?=$history->username; ?></td>
                            <td><?=$history->amount; ?></td>
                            <td><?=date('H:i:s d:m:Y',$history->created); ?></td>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3"><?= Yii::t('app', 'Нет записей') ?></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
