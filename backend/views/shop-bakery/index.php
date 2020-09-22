<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShopBakerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пироги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-bakery-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'alias',
            //'alias2',
            //'img',
            'price_for_sell',
            'price_to_buy',
            // 'level',
            'min_count_for_sell',
            // 'model_name',
            //// 'energy',
            // 'experience',
            'energy_in_food',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
