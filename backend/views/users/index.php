<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            // 'status',
            // 'role',
            // 'created_at',
            // 'updated_at',
            // 'first_name',
            // 'last_name',
            // 'sex',
            // 'birthday',
            // 'city',
            // 'country',
            // 'about:ntext',
            // 'photo',
            'level',
            'for_pay',
            'for_out',
            // 'pay_pass',
            // 'experience',
            // 'energy',
            // 'phone',
            // 'chat_status',
            // 'chat_music',
            // 'ref_id',
            // 'ref_for_out',
            // 'refLink',
            // 'is_subscribed',
            // 'banned',
            // 'banned_text:ntext',
            // 'need_experience',
            // 'signup_date',
            // 'login_date',
            // 'signup_ip',
            // 'last_ip',
            // 'first_login',
            // 'outed',
            // 'location',
            // 'last_visited',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
