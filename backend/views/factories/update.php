<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Factories */

$this->title = 'Изменить фабрику: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Factories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->factory_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="factories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
