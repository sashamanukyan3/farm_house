<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Factories */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фабрика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->factory_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->factory_id], [
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
            'factory_id',
            'name',
            'alias',
            'img',
            'price_to_buy',
            'level',
            //'energy',
            'experience',
        ],
    ]) ?>

</div>
