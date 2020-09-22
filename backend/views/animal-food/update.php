<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AnimalFood */

$this->title = 'Изменить корм животных: ' . ' ' . $model->animal_food_id;
$this->params['breadcrumbs'][] = ['label' => 'Корм животных', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->animal_food_id, 'url' => ['view', 'id' => $model->animal_food_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="animal-food-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'plant' => $plant,
    ]) ?>

</div>
