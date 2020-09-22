<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SupportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тех. поддержка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            [
                'attribute' => 'from',
                'value' => function($data) {
                    return $data->userreply->username;
                },
            ],
//            'to',
            //'message',
            [
                'attribute'=>'date',
                'value' => function($data) {
                    return date('Y:m:d H:i:s', $data->date);
                }
            ],
            [
                'attribute'=>'status',
                'value' => function($date){
                    switch($date->status)
                    {
                        case 1: $status = 'Открыт'; break;
                        case 2: $status = 'Закрыт'; break;
                        case 3: $status = 'Отвечено'; break;
                        case 4: $status = 'Просмотрен'; break;
                    }
                    return $status;
                }
            ],
            // 'status',
            // 'user_viewed',
            // 'reply',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete} {update}'],
        ],
    ]); ?>

</div>
