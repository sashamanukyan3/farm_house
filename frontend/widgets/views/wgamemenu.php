<?php

use yii\helpers\Url;

?>
<!-- Gide -->
<div class="none-st">
    <a href="<?= Url::toRoute('/game/index') ?>"><img class="home" src="/img/home.png"></a>
    <div class="gide1" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Загон кур') ?>">
        <a class="click-1 bmd-ripple" href="<?= Url::toRoute('/game/paddock-chickens') ?>"></a>
    </div>
    <div class="gide2" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Загон бычков') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/paddock-bulls') ?>"></a>
    </div>
    <div class="gide3" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Загон коз') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/paddock-goats') ?>"></a>
    </div>
    <div class="gide4" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Загон коров') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/paddock-cows') ?>"></a>
    </div>
    <div class="gide5" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Ярмарка') ?>">
        <a class="click-2 bmd-ripple" href="" data-toggle="modal" data-target="#myModal"></a>
    </div>
    <div class="gide6" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Склад') ?>">
        <a class="click-2 bmd-ripple" href="" data-toggle="modal" data-target="#myStock"></a>
    </div>
    <div class="gide7" data-bmd-state="default" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= Yii::t('app', 'Поля') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/land') ?>"></a>
    </div>
    <div class="gide8" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Фабрика теста') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/factory-dough') ?>"></a>
    </div>
    <div class="gide9" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Фабрика фарша') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/factory-mince') ?>"></a>
    </div>
    <div class="gide10" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Фабрика сыра') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/factory-cheese') ?>"></a>
    </div>
    <div class="gide11" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Фабрика творога') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/factory-curd') ?>"></a>
    </div>
    <div class="gide12" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Пекарня Пирог с мясом') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/meat-bakery') ?>"></a>
    </div>
    <div class="gide13" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Пекарня Пирог с сыром') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/cheese-bakery') ?>"></a>
    </div>
    <div class="gide14" data-bmd-state="default" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?= Yii::t('app', 'Пекарня Пирог с творогом') ?>">
        <a class="click-2 bmd-ripple" href="<?= Url::toRoute('/game/curd-bakery') ?>"></a>
    </div>
</div>
<!-- Gide End -->
