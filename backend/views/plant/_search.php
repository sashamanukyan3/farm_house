<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PlantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'plant_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'img1') ?>

    <?= $form->field($model, 'img2') ?>

    <?= $form->field($model, 'img3') ?>

    <?php // echo $form->field($model, 'img4') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'energy') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
