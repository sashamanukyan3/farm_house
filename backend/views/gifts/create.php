<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Gifts */

$this->title = 'Добавить подарок';
$this->params['breadcrumbs'][] = ['label' => 'Подарки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gifts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
