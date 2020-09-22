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
            <div class="faq_page_title"><?= Yii::t('app', 'Написать письмо') ?></div>
            <ul class="bonus_ul">

                <div class="col-md-5" style="padding-bottom: 20px">

                    <a href="<?= Url::toRoute('/mails/send/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Написать письмо') ?></a>
                    <a href="<?= Url::toRoute('/mails/in//') ?>" class="sup-add-menu"><?= Yii::t('app', 'Входящие') ?> (<?= $inTotalCount ?>/<?= $inViewedCount ?>)</a>
                    <a href="<?= Url::toRoute('/mails/out/') ?>/" class="sup-add-menu sup-add-menu-active"><?= Yii::t('app', 'Исходящие') ?> (<?= $outTotalCount ?>/<?= $outViewedCount ?>)</a>

                    <?php if($mails){ ?>

                        <table class="mails-table">
                            <tr>
                                <td><?= Yii::t('app', 'Дата') ?></td>
                                <td><?= Yii::t('app', 'Фермер') ?></td>
                                <td><?= Yii::t('app', 'Тема') ?></td>
                                <td><?= Yii::t('app', 'Действие') ?></td>
                                <td><?= Yii::t('app', 'Статус') ?></td>
                            </tr>
                            <?php foreach($mails as $mail){ ?>
                                <tr>
                                    <td class="mails-out-data"><?= $mail->date; ?></td>
                                    <td class="mails-out-username"><?= $mail->to; ?></td>
                                    <td class="mails-out-subject"><?= $mail->subject; ?></td>
                                    <td class="mails-out-message">
                                        <a href="<?= Url::toRoute('/mails/outview?id=' . $mail->mail_id) ?>"><?= Yii::t('app', 'Просмотр') ?></a>
                                        <a href="<?= Url::toRoute('/mails/outdelete?id=' . $mail->mail_id) ?>"><?= Yii::t('app', 'Удалить') ?></a>
                                    </td>
                                    <td>
                                        <?php if($mail->status == 1){ ?>
                                            <center><img src="/img/message1.png" width="30px" height="30px" alt=""></center>
                                        <?php }else{ ?>
                                            <center><img src="/img/message.png" width="30px" height="30px" alt=""></center>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        </table>

                    <?php } ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>