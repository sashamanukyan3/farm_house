<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Бонус') ?></div>
            <ul class="bonus_ul">

                <p><b><?= Yii::t('app', 'Пополнить резерв бонусов') ?></b> <a href="<?= Url::toRoute('/bonus/index') ?>">&lt;&lt;<?= Yii::t('app', 'Бонус') ?></a></p>

                <div class="bonus-add">
                    <p><?= Yii::t('app', 'Резерв бонусов') ?></p>

                    <p><?= Yii::t('app', 'Пополнено на') ?>: <?php if($test){echo $test; }else{echo '0';} ?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></p>

                    <p><?= Yii::t('app', 'В наличии') ?>: <?php echo $BonusRemaining->price; ?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></p>

                    <?php $form = ActiveForm::begin(); ?>

                    <div style="width: 170px;"><?= $form->field($model, 'price')->textInput(['name' => 'price'])->label(false); ?></div>

                    <?= Html::submitButton(Yii::t('app', 'Пополнить'), ['class' => 'btn btn-primary mail-post']) ?>

                    <?php ActiveForm::end(); ?>

                </div>

                <div class="bonus-add-list">

                    <?php if($BonusAddList){ ?>
                        <p class="bonus-title"><?= Yii::t('app', 'Последние 30 пополнений') ?></p>
                        <div class="col-md-6">

                            <table class="table table-bordered">
                                <tr class="table-title">
                                    <td><?= Yii::t('app', 'Фермер') ?></td>
                                    <td><?= Yii::t('app', 'Сумма') ?></td>
                                    <td><?= Yii::t('app', 'Дата') ?></td>
                                </tr>
                                <?php foreach($BonusAddList as $list){ ?>
                                    <tr>
                                        <td><a href="<?= Url::toRoute('/profile/view/' . $list->username) ?>" style="color: #fff"><?= $list->username; ?></a></td>
                                        <td><?= $list->price; ?></td>
                                        <td><?=  date('H:i:s d:m:Y', $list->date); ?></td>
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

