<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователь', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            'role',
            //'created_at',
            //'updated_at',
            'first_name',
            'last_name',
            'sex',
            'birthday',
            'city',
            'country',
            'about:ntext',
            'photo',
            'level',
            'for_pay',
            'for_out',
            //'pay_pass',
            'experience',
            'energy',
            'phone',
            'chat_status',
            'chat_music',
            'ref_id',
            'ref_for_out',
            'refLink',
            'is_subscribed',
            'banned',
            'banned_text:ntext',
            'need_experience',
            'signup_date:datetime',
            'login_date:datetime',
/*            [
                'attribute'=>'signup_date',
                'format'=>['date', 'Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'login_date',
                'format'=>['date', 'Y-m-d H:i:s'],
            ],*/
            'signup_ip',
            'last_ip',
            //'first_login',
            'outed',
            'location',
            'last_visited:datetime',
        ],
    ]) ?>

</div>
