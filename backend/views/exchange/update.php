<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Exchange */

$this->title = 'Изменить: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Биржа опыта', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="exchange-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
