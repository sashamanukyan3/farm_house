<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PayOut */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заявка на вывод средств', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-out-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'amount',
            'pay_type',
            'purse',
            'created_at',
            'status_id',
        ],
    ]) ?>

</div>
