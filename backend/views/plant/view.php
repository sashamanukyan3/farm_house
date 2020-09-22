<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Plant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Семена', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->plant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->plant_id], [
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
            'plant_id',
            'name',
            'img1',
            'img2',
            //'img3',
            //'img4',
            'level',
            'price_to_buy',
            //'price_for_sell',
            //'weight',
            'energy',
            'experience',
        ],
    ]) ?>

</div>
