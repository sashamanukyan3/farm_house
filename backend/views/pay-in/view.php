<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PayIn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пополнения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-in-view">

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
            'username',
            'created',
            'purse',
            'amount',
            //'m_sign',
            //'fraud_count',
            'complete',
        ],
    ]) ?>

</div>
