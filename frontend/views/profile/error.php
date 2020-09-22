<?php
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-6 col-md-offset-3 boxshow">

            <h3 style="color: red"><?= Yii::t('app', 'Такого пользователя нет') ?></h3>

            <a href="<?= Url::toRoute('/profile/index/') ?>" style="color: green"><?= Yii::t('app', 'Моя Страница') ?></a>
            <br><br>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
