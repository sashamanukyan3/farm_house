<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Изменить: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователь', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <a href="#" class="tooltip-info">
        <div class="glyphicon glyphicon-info-sign"></div>
		<span class="custom info"><em>Информация</em>
            Роли: <blockquote>1 - админ<br>
                  2 - модератор<br>
                  3 - зарегистрированный пользователь
                </blockquote>
            Бан: <blockquote>0 - по умолчанию<br>
                 1 - забанен
                </blockquote>
		</span>
    </a>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
