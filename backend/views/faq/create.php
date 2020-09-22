<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'F.A.Q', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
