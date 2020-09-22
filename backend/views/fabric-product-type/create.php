<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FabricProductType */

$this->title = 'Добавить продукцию для фабрики';
$this->params['breadcrumbs'][] = ['label' => 'Продукция для фабрик', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fabric-product-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
