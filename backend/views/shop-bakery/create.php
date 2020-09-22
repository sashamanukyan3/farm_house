<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopBakery */

$this->title = 'Добавить пирог';
$this->params['breadcrumbs'][] = ['label' => 'Пироги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-bakery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
