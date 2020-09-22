<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FactoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фабрики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'factory_id',
            'name',
            //'alias',
            //'img',
            'price_to_buy',
            'level',
            //'energy',
            'experience',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
