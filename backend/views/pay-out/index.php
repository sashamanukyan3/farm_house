<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PayOutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки на вывод средств';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-out-index">

    <h1>Список запросов</h1>
    <span style="color:green"><?= Yii::$app->session->getFlash('pay_out_cancel'); ?></span>
    <span style="color:green"><?= Yii::$app->session->getFlash('pay_out_ok'); ?></span>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'amount',
            'pay_type',
            'purse',
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return date('Y:m:d H:i:s',$data->created_at);
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{cancel}{accept}',
                'buttons' => [
                    'cancel' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-remove-circle"></span>', $url  ,['title'=>'Отменить запрос']
                        );
                    },
                    'accept' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>', $url  , ['title'=>'Подтвердить запрос']);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
