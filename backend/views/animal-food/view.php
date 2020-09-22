<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AnimalFood */

$this->title = $model->animal_food_id;
$this->params['breadcrumbs'][] = ['label' => 'Корм животных', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="animal-food-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->animal_food_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->animal_food_id], [
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
            'animal_food_id',
            'plant.second_name',
            'alias',
            'price_to_buy',
            'plant.price_for_sell',
            'min_count',
            'energy',
            'experience',
        ],
    ]) ?>

</div>
