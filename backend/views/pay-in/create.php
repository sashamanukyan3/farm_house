<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PayIn */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Пополнения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-in-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($msg != ''){?><h5 class="alert alert-danger"><?=$msg;?></h5><?php }?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
