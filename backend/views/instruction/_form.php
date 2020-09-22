<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\fileapi\Widget as FileAPI;
use yii\web\UploadedFile;
use vova07\imperavi\Widget;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Instruction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название'); ?>

    <?= $form->field($model, 'weight')->textInput()->label('weight'); ?>


    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            //'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => Yii::$app->urlManager->createUrl('file-upload/upload'),
            'lang' => 'ru',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ]); ?>
    <?= $form->field($model, 'content_en')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            //'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => Yii::$app->urlManager->createUrl('file-upload/upload'),
            'lang' => 'ru',
            'plugins' => ['clips', 'fontcolor','imagemanager']
        ]
    ]); ?>
    <?= $form->field($model, 'is_active')->widget(CheckboxX::className(), [
        'model' => $model,
        'pluginOptions' => [
        'threeState' => false,
        'size' => 'md'
        ]
    ])->label('Показать'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
