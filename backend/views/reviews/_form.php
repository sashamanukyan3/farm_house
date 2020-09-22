<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'disabled' => 'disabled']) ?>

    <?= $form->field($model, 'date')->textInput(['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'is_active')->widget(\kartik\checkbox\CheckboxX::className(), [
        'model' => $model,
        'pluginOptions' => [
            'threeState' => false,
            'size' => 'md'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
