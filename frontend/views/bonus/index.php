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
            <div class="faq_page_title"><?= Yii::t('app', 'Бонус') ?></div>
            <ul class="bonus_ul">

                <div class="bonus-add">
                    <p>
                        <?= Yii::t('app', 'Каждый час вы можете получать бонус на баланс оплаты в размере {rub} руб.', [
                            'rub' => \common\models\Settings::$bonusAdd,
                        ]) ?>
                        <br>
                        <?= Yii::t('app', 'При сборе бонусов у вас списывается {energyUnits} ед энергии.', [
                            'energyUnits' => \common\models\Settings::$bonusEnergy,
                        ]) ?>
                        <br>
                        <?= Yii::t('app', 'Резерв бонусов') ?>: <?php echo $BonusRemaining->price; ?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?>. <a href="<?= Url::toRoute('/bonus/add') ?>"><?= Yii::t('app', 'Пополнить') ?>&gt;&gt;</a><br></p>

                    <p class="bonus-title"><?= Yii::t('app', 'Получить бонус') ?></p>

                    <?php $form = ActiveForm::begin(); ?>

                    <span style="display: none"><?= $form->field($BonusBuyModel, 'username')->textInput(['value' => Yii::$app->user->identity->username])->label(false); ?></span>

                    <span style="display: none"><?= $form->field($BonusBuyModel, 'date')->textInput(['value' => time()])->label(false); ?></span>

                    <div style="width:272px"><?= $form->field($BonusBuyModel, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div style="clear:both; margin-top: 12px;"></div><div class="col-lg-6">{input}</div></div>',
                    ])->label(false); ?></div>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Получить'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <div class="bonus-add-list">

                    <?php if($BonusBuyList){ ?>

                        <p class="bonus-title"><?= Yii::t('app', 'Последние 10 полученных бонусов') ?></p>
                        <div class="col-md-6">

                            <table class="table table-bordered">
                                <tr  class="table-title">
                                    <td><?= Yii::t('app', 'Фермер') ?></td>
                                    <td><?= Yii::t('app', 'Сумма') ?></td>
                                    <td><?= Yii::t('app', 'Дата') ?></td>
                                </tr>
                                <?php foreach($BonusBuyList as $list){ ?>
                                    <tr>
                                        <td><a href="<?= Url::toRoute('/profile/view/' . $list->username) ?>" style="color: #fff"><?= $list->username; ?></a></td>
                                        <td><?= $list->summ ?></td>
                                        <td><?= date('H:i:s d:m:Y', $list->date); ?></td>
                                    </tr>
                                <?php } ?>
                            </table>

                        </div>

                    <?php } ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>

