<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ферма - Запрос сброса пароля';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Запрос сброса пароля!') ?></div>
            <div class="site-request-password-reset">
                <?php if($msg != ''){?><span style="color:#388e3c; font-size:16px;"><?=$msg; ?></span><?php } ?><br>
                <p><?= Yii::t('app', 'Пожалуйста, заполните ваш адрес электронной почты. Ссылка для сброса пароля будет отправлена туда.') ?></p>

                <div class="row">
                    <div class="col-lg-5">
                        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'type' => 'text','size'=>15, 'style'=>'width:50%']) ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>