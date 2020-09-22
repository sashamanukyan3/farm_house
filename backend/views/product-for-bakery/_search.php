<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProductForBakerySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-for-bakery-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'alias2') ?>

    <?= $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'price_to_buy') ?>

    <?php // echo $form->field($model, 'price_for_sell') ?>

    <?php // echo $form->field($model, 'min_count') ?>

    <?php // echo $form->field($model, 'min_count_for_sell') ?>

    <?php // echo $form->field($model, 'model_name') ?>

    <?php // echo $form->field($model, 'energy') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
