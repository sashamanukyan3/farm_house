<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<div class="bmd-page-container padd">
    <div class="container">

        <div class="col-md-12 pri">
            <div class="faq_page_title mails_title"><?= Yii::t('app', 'Написать письмо') ?></div>
            <ul class="bonus_ul">
                <span class="from" style="display:none;"><?=\Yii::$app->user->identity->username; ?></span>

                <div class="col-md-5" style="padding-bottom: 20px;">

                    <?php if($mails){ ?>

                        <a href="<?= Url::toRoute('/mails/send/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Написать письмо') ?></a>
                        <a href="<?= Url::toRoute('/mails/in/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Входящие') ?> (<?= $inTotalCount ?>/<?= $inViewedCount ?>)</a>
                        <a href="<?= Url::toRoute('/mails/out/') ?>" class="sup-add-menu sup-add-menu-active"><?= Yii::t('app', 'Исходящие') ?> (<?= $outTotalCount ?>/<?= $outViewedCount ?>)</a>
                        <div style="clear:both"></div>

                        <div class="mails-out-list">

                            <?php foreach($mails as $mail){ ?>
                                <span class="mails-inview-title"><?= Yii::t('app', 'Дата') ?>:</span>
                                <span class="mails-inview-text"><?= $mail->date; ?></span>
                                <br>
                                <span class="mails-inview-title"><?= Yii::t('app', 'Логин отправителя') ?>:</span>
                                <span class="mails-inview-text"><?= $mail->to; ?></span>
                                <br>
                                <span class="mails-inview-title"><?= Yii::t('app', 'Тема') ?>:</span>
                                <span class="mails-inview-text"><?= $mail->subject; ?></span>
                                <br>
                                <span class="mails-inview-title"><?= Yii::t('app', 'Сообщение') ?>:</span>
                                <span class="mails-inview-message mails-inview-text"><?= $mail->message; ?></span>
                            <?php } ?>

                        </div>

                    <?php }else{

                    } ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>