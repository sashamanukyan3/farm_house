<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <span style="color:green"><?= Yii::$app->session->getFlash('notify'); ?></span>
    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{notify} {view} {update} {delete}',
                'buttons' => [
                    'notify' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-off"></span>', $url,['title'=>'Включить оповещение пользователей']
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
