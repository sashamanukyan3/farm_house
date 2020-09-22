<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Plant */

$this->title = 'Изменить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Семена', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->plant_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="plant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
