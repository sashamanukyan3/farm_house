<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Instruction */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Инструкция', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
