<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Ферма - Сброс пароля');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Сброс пароля') ?></div>
            <div class="site-reset-password">
                <?php if($msg != ''){?><span style="color:#388e3c; font-size:16px;"><?=$msg; ?></span><?php } ?><br>
                <p><?= Yii::t('app', 'Пожалуйста, выберите Ваш новый пароль') ?>:</p>

                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                            <?= $form->field($model, 'password')->passwordInput(['style'=>'width:50%']) ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>