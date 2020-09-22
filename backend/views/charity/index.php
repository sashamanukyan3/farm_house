<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CharitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Благотворительность';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-index">

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
            'age',
            'address',
            'text:ntext',
            // 'need',
            // 'content:ntext',
            // 'img',
            // 'summ',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
