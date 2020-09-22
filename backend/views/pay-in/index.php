<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PayInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика пополнений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить пополнение', ['create'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',

            'purse',
            'amount',
            [
                'attribute' => 'complete',
                'value' => function($data) {
                    return ($data->complete)?'Да':'Нет';
                },
            ],
            [
                'attribute' => 'created',
                'value' => function($data) {
                    return date('Y:m:d H:i:s',$data->created);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
