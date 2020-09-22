<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Animals */

$this->title = 'Изменить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Животные', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->animal_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="animals-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
