<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Plant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plant-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img1')->fileInput() ?>

    <?= $form->field($model, 'img2')->fileInput() ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'price_to_buy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'energy')->textInput() ?>

    <?= $form->field($model, 'experience')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
