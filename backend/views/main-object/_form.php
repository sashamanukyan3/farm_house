<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model common\models\MainObject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-object-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_lvl')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'is_active')->widget(CheckboxX::className(), [
        'model' => $model,
        'pluginOptions' => [
            'threeState' => false,
            'size' => 'md'
        ]
    ])->label('Показать'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
