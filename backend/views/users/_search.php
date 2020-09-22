<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?= $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'for_pay') ?>

    <?php // echo $form->field($model, 'for_out') ?>

    <?php // echo $form->field($model, 'pay_pass') ?>

    <?php // echo $form->field($model, 'experience') ?>

    <?php // echo $form->field($model, 'energy') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'chat_status') ?>

    <?php // echo $form->field($model, 'chat_music') ?>

    <?php // echo $form->field($model, 'ref_id') ?>

    <?php // echo $form->field($model, 'ref_for_out') ?>

    <?php // echo $form->field($model, 'refLink') ?>

    <?php // echo $form->field($model, 'is_subscribed') ?>

    <?php // echo $form->field($model, 'banned') ?>

    <?php // echo $form->field($model, 'banned_text') ?>

    <?php // echo $form->field($model, 'need_experience') ?>

    <?php // echo $form->field($model, 'signup_date') ?>

    <?php // echo $form->field($model, 'login_date') ?>

    <?php // echo $form->field($model, 'signup_ip') ?>

    <?php // echo $form->field($model, 'last_ip') ?>

    <?php // echo $form->field($model, 'first_login') ?>

    <?php // echo $form->field($model, 'outed') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'last_visited') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
