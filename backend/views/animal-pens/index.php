<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AnimalPensSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Загоны';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="animal-pens-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'animal_pens_id',
            'name',
            //'alias',
            //'img',
            'price_to_buy',
            'level',
            'energy',
            'experience',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
