<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\BakeriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bakeries-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bakery_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'price_to_buy') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'energy') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
