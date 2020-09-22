<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductForBakery */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукция для пекарни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-for-bakery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'alias',
            'alias2',
            'img',
            'price_to_buy',
            'price_for_sell',
            'min_count',
            'min_count_for_sell',
            'model_name',
            //'energy',
            //'experience',
        ],
    ]) ?>

</div>
