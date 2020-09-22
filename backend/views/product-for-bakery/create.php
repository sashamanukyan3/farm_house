<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductForBakery */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Продукция для пекарни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-for-bakery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
