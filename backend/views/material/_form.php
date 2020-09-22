<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => Url::to(['/site/image-upload']),
            'imageManagerJson' => Url::to(['/site/images-get']),
            'selector' => '#my-textarea-id',
            'plugins' => [
                'imagemanager',
                'fullscreen',
                'limiter',
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'is_enabled')->widget(CheckboxX::className(), [
        'model' => $model,
        'pluginOptions' => [
            'threeState' => false,
            'size' => 'md'
        ]
    ])->label('Показать'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
