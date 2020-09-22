<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\CharitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="charity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'age') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'need') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'summ') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
