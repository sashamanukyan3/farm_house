<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WallComments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Комментарий к стене', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wall-comments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'wall_id',
            'text:ntext',
            'created_at',
        ],
    ]) ?>

</div>
