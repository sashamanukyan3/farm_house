<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'edit-form']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'teaser')->textarea(['rows' => 6]) ?>

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

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'teaser_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content_en')->widget(Widget::className(), [
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

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'is_active')->widget(CheckboxX::className(), [
        'model' => $model,
        'pluginOptions' => [
            'threeState' => false,
            'size' => 'md'
        ]
    ])->label('Показать'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
