<?php

use yii\helpers\Url;

?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'История реферальных начислений') ?></h4>
            <hr>
            <p><a href="<?= Url::toRoute('/profile/login-history') ?>"><?= Yii::t('app', 'Вход в аккаунт') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/in-history') ?>"><?= Yii::t('app', 'Пополнение баланса') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/transfer-history') ?>"><?= Yii::t('app', 'Переводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/exchange-history') ?>"><?= Yii::t('app', 'Обмены средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/out-history') ?>"><?= Yii::t('app', 'Выводы средств') ?></a></p>
            <p><a href="#" style="font-weight: bold;"><?= Yii::t('app', 'Партнёрская программа') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/my-history') ?>"><?= Yii::t('app', 'Покупка животных, корма и загонов') ?></a></p>
            <span><?= Yii::t('app', 'Общая сумма начислений') ?>: <?= ($allSum) ? $allSum : 0?></span>
            <table class="table table-striped table-hover " style="margin-bottom:0 !important;">
                <thead>
                <tr >
                    <th><?= Yii::t('app', 'Реферал') ?></th>
                    <th><?= Yii::t('app', 'Сумма (руб)') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($items as $history) : ?>
                    <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                    <tr class="<?= $class;?>">
                        <td><?=$history->username; ?></td>
                        <td><?=$history->count_price; ?></td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]);
            ?>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
