<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnimalPens */

$this->title = 'Изменить загон: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Animal Pens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->animal_pens_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="animal-pens-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
