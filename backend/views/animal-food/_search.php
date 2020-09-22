<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\AnimalFoodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="animal-food-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'animal_food_id') ?>

    <?= $form->field($model, 'plant_id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'price_to_buy') ?>

    <?= $form->field($model, 'min_count') ?>

    <?php // echo $form->field($model, 'energy') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
