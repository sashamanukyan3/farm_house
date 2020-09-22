<?php use yii\helpers\Html; ?>
<!-- Info -->
<div class="col-md-5 table_info brb">
    <div class="col-md-4 nstyle" style="z-index:1000;">
        <span data-bmd-state="default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= Yii::t('app', 'Деньги для вывода') ?> <?=$user->for_out?>">
            <img src="/img/monet.png"/><span class="user_for_pay"> <?=$user->for_pay;?> </span>
        </span>
    </div>
    <div class="col-md-4 nstyle">
        <span data-bmd-state="default" data-toggle="tooltip" data-placement="bottom" >
            <img src="/img/energy.png"/><span class="user_energy"> <?=$user->energy;?> </span>
        </span>
    </div>
    <div class="col-md-4 nstyle">
        <span data-bmd-state="default" data-toggle="tooltip" data-placement="bottom" data-original-title="<?= Yii::t('app', 'До следующего уровня необходимо') ?> <?=$user->need_experience - $user->experience;?>">
            <img src="/img/hard.png"/><span class="user_experience"> <?=$user->experience;?> </span>
        </span>
    </div>
</div>
<!-- Info End -->
<!-- User -->
<div class="col-md-3 table_info brl">
    <div class="col-md-12 baac1">
        <div class="col-md-4 nonestyle">
            <img class="game_ava" src="/avatars/<?=$user->photo;?>"/>
        </div>
        <div class="col-md-8 nonestyle">
            <div class="">
                <span class="krug" style="cursor: default; background:green;padding:2px 5px 6px 5px;"><?=$user->username;?></span>
                <?= Html::a( Yii::t('app', 'На сайт'), ['/'], ['data' => ['method' => 'POST'], 'class'=>'btn btn-danger bmd-ripple btn-xs set krug']) ?>
            </div>
            <div class="prog">
                <span><?= Yii::t('app', 'Уровень') ?>:<span class="badge bmd-bg-primary set" id="user_lvl"><?=$user->level;?></span></span>
            </div>
        </div>
    </div>
</div>
<!-- User End -->