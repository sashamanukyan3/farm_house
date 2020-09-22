<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Exchange */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exchange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->dropDownList([
                            'egg' => 'Яица',
                            'meat' => 'Мяс',
                            'goat_milk' =>'Молоко козы',
                            'cow_milk' =>'Молоко коровы',
                            'dough' => 'Тесто',
                            'mince' => 'Фарш',
                            'cheese' => 'Сыр',
                            'curd' => 'Творог',
                            ]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'energy')->textInput() ?>

    <?= $form->field($model, 'experience')->textInput() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
