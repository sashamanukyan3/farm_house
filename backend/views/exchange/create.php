<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Exchange */

$this->title = 'Биржа опыта';
$this->params['breadcrumbs'][] = ['label' => 'Биржа опыта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
