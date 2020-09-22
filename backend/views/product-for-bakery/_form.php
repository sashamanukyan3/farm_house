<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductForBakery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-for-bakery-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->fileInput() ?>

    <?= $form->field($model, 'price_to_buy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_for_sell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_count')->textInput() ?>

    <?= $form->field($model, 'min_count_for_sell')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
