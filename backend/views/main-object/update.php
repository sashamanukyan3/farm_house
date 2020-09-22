<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MainObject */

$this->title = 'Update Main Object: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Main Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-object-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
