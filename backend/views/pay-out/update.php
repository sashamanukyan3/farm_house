<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PayOut */

$this->title = 'Изменитьt: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Запрос на вывод средств', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="pay-out-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <a href="#" class="tooltip-info">
        <div class="glyphicon glyphicon-info-sign"></div>
		<span class="custom info"><em>Информация</em>
            Статус: <blockquote>1 - В обработке<br>
                2 - Завершен<br>
                3 - Отменен
            </blockquote>
		</span>
    </a>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
