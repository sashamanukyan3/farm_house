<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AnimalFoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Корм животных';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="animal-food-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!--
    <p>
        <?/*= Html::a('Добавить корм животных', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'animal_food_id',
            'plant.second_name',
            //'alias',
            'price_to_buy',
            'plant.price_for_sell',
            'min_count',
            'energy',
            'experience',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
