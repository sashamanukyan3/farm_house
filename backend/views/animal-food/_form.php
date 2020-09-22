<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AnimalFood */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="animal-food-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($plant, 'second_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_to_buy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($plant, 'price_for_sell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_count')->textInput() ?>

    <?= $form->field($model, 'energy')->textInput() ?>

    <?= $form->field($model, 'experience')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
