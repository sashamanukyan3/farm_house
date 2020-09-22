<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FabricProductType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукция для фабрик', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fabric-product-type-view">

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
