<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Charity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Благотворительность', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="charity-view">

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
            'age',
            'address',
            'text:ntext',
            'need',
            'content:ntext',
            'img',
            'summ',
        ],
    ]) ?>

</div>
