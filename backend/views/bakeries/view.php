<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Bakeries */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пекарни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bakeries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->bakery_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->bakery_id], [
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
            'bakery_id',
            'name',
            'alias',
            'img',
            'price_to_buy',
            'level',
            'energy',
            'experience',
        ],
    ]) ?>

</div>
