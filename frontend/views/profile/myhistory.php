<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'История покупок животных, корма и загонов') ?></h4>
            <hr>

            <p><a href="<?= Url::toRoute('/profile/login-history') ?>"><?= Yii::t('app', 'Вход в аккаунт') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/in-history') ?>"><?= Yii::t('app', 'Пополнение баланса') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/transfer-history') ?>"><?= Yii::t('app', 'Переводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/exchange-history') ?>"><?= Yii::t('app', 'Обмены средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/out-history') ?>"><?= Yii::t('app', 'Выводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/history') ?>"><?= Yii::t('app', 'Партнёрская программа') ?></a></p>
            <p><a href="#" style="font-weight: bold;"><?= Yii::t('app', 'Покупка животных, корма и загонов') ?></a></p>

            <span><?= Yii::t('app', 'Общая сумма покупок') ?>: <?= ($allSum) ? $allSum : 0 ?></span>
            <table class="table table-striped table-hover ">
                <thead>
                <tr >
                    <th><?= Yii::t('app', 'Сумма (руб)') ?></th>
                    <th><?= Yii::t('app', 'Количество') ?></th>
                    <th><?= Yii::t('app', 'Комментарий') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($myPurchaseHistory as $history) : ?>
                    <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                    <tr class="<?= $class;?>">
                        <td><?=$history->count_price; ?></td>
                        <td><?=$history->count_product; ?></td>
                        <td><?=$history->comment; ?></td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
