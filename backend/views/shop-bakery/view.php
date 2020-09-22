<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ShopBakery */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пироги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-bakery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            //'alias',
            //'alias2',
            'img',
            'price_for_sell',
            'price_to_buy',
            //'level',
            'min_count_for_sell',
            'model_name',
            //'energy',
            //'experience',
            'energy_in_food',
        ],
    ]) ?>

</div>
