<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Bakeries */

$this->title = 'Изменить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пекарни', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->bakery_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="bakeries-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
