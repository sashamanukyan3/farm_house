<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductForBakery */

$this->title = 'Изменить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукция дял пекарни', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="product-for-bakery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
