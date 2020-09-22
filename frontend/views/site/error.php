<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">
    <div class="page-not-found">
        <h1>Ошибка 404</h1>
        <h2>Страница не существует или она была удалена</h2>
        <a href="<?= Url::toRoute('/') ?>"><h3>На главную</h3></a>
    </div>
</div>
<style>
    h1{
        font-size: 66px;
    }
    h2{
        font-size: 40px;
    }
    h3{
        font-size: 30px;
    }
    .site-error{
        padding-top:60px;
    }
    .page-not-found{
        width: 50%;
        margin: auto;
    }
    .page-not-found > h1, h2{
        text-align:center;
        color: #424242;
        margin-top:10%;
    }
    .page-not-found >a>h3{
        text-align: center;
        margin-top:10%;
    }
</style>