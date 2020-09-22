<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WallCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарий к стене';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wall-comments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'user_id',
                'value' => function($data) {
                    if(is_object($data->user)) {
                        return $data->user->username;
                    }
                },
            ],
            [
                'attribute' => 'wall_id',
                'value' => function($data) {
                    if(is_object($data->wall)) {
                        return $data->wall->content;
                    }
                },
            ],
            'text:ntext',
//            'created_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>

</div>
