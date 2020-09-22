<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PlantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Семена';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'plant_id',
            'name',
            //'img1',
            //'img2',
            //'img3',
            // 'img4',
            'level',
            'price_to_buy',
            //'price_for_sell',
            // 'weight',
            'energy',
            'experience',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
