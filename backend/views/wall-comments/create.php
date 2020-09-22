<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WallComments */

$this->title = 'Комментарий к стене';
$this->params['breadcrumbs'][] = ['label' => 'Комментарий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wall-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
