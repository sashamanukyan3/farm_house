<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PayInSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-in-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'purse') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'm_sign') ?>

    <?php // echo $form->field($model, 'fraud_count') ?>

    <?php // echo $form->field($model, 'complete') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
