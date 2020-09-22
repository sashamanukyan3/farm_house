<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MainObject */

$this->title = 'Create Main Object';
$this->params['breadcrumbs'][] = ['label' => 'Main Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
