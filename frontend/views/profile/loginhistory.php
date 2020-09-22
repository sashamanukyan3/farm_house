<?php
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'История входа в аккаунт') ?></h4>
            <hr>
            <p><a href="#" style="font-weight: bold;"><?= Yii::t('app', 'Вход в аккаунт') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/in-history') ?>"><?= Yii::t('app', 'Пополнение баланса') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/transfer-history') ?>"><?= Yii::t('app', 'Переводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/exchange-history') ?>"><?= Yii::t('app', 'Обмены средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/pay/out-history') ?>"><?= Yii::t('app', 'Выводы средств') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/history') ?>"><?= Yii::t('app', 'Партнёрская программа') ?></a></p>
            <p><a href="<?= Url::toRoute('/profile/my-history') ?>"><?= Yii::t('app', 'Покупка животных, корма и загонов') ?></a></p>
            <table class="table table-striped table-hover ">
                <thead>
                <tr >
                    <th><?= Yii::t('app', '№') ?></th>
                    <th>IP</th>
                    <th><?= Yii::t('app', 'Дата') ?></th>
                    <th><?= Yii::t('app', 'Браузер') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($loginHistory as $history) : ?>
                    <?php $class = ($i%2==0) ? 'info' : 'active'; ?>
                    <tr class="<?= $class;?>">
                        <td><?=$i;?></td>
                        <td><?=$history->login_ip; ?></td>
                        <td><?=date('Y-m-d H:i:s', $history->login_date); ?></td>
                        <td><?=$history->browser; ?></td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>