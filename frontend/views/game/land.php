<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!doctype html>
<?php $time = date('H', time()); ?>
<?php if($time > 7 && $time < 21): ?>
<html style="background: url('/img/bgiday.png') no-repeat fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
<?php else: ?>
<html style="background: url('/img/bgnight.png') no-repeat fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
<?php endif; ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= Yii::t('app', 'Фермерский дом') ?></title>
    <!--Style-->
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/flaticon.css">
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/prettify.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/gamev2.css">
    <link rel="stylesheet" href="/css/progame.css">
    <link rel="stylesheet" href="/css/screen.css">
    <!--Style End-->
</head>
<?php if($time > 7 && $time < 21): ?>
<body style="background: url('/img/gameday.png');
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
<?php else: ?>
<body style="background: url('/img/gamenight.png');
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
<?php endif; ?>
<!-- Widgets -->
<div class="wrapper">
    <!-- Gid -->
    <div class="col-md-12 col-min">
        <div class="col-md-3 table_info brr">
            <div class="col-md-12 baac1">
                <div class="col-md-4 nonestyle set">
                    <img class="game_ava set" src="/img/icon/5.png"/>
                </div>
                <div class="col-md-8 nonestyle">
                    <div class="">
                        <center><h3 class="ttinfo"><?= Yii::t('app', 'Поля') ?>
                                <a href="#" class="tooltip-info">
                                    [?]
                                    <span class="custom info"><em><?= Yii::t('app', 'Информация') ?></em>
                                        <?= Yii::t('app', 'На полях вы можете посеять семена и получить корм для животных') ?>.<br>
                                        <?= Yii::t('app', 'Каждый посев забирает 2 ед. энергии') ?>.<br>
                                        <?= Yii::t('app', 'Чтобы засеять поле, вам необходимо купить семена на ярмарке') ?>!<br>
                                        <?= Yii::t('app', 'Доступно 4 вида семян') ?>:<br>
                                        <?= Yii::t('app', 'Пшеница Необходима для кормления кур в загонах! Время созревания: 30 минут. Можно использовать 1ед энергии для уменьшения созревания на 15 минут') ?>.<br>
                                        <?= Yii::t('app', 'Клевер Необходим для кормления бычков в загонах! Время созревания: 45 минут. Можно использовать 1ед энергии для уменьшения созревания на 23 минут') ?>.<br>
                                        <?= Yii::t('app', 'Капуста Необходима для кормления коз в загонах! Время созревания: 60 минут. Можно использовать 1ед энергии для уменьшения созревания на 30 минут') ?>.<br>
                                        <?= Yii::t('app', 'Свекла Необходима для кормления коров в загонах! Время созревания: 135 минут. Можно использовать 1ед энергии для уменьшения созревания на 68 минут') ?>.<br>
                                        <?= Yii::t('app', 'Цена покупки полей: 2 руб') ?>.<br>

                                    </span>
                                </a>
                        </h3></center>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gid End -->
        <?=\frontend\widgets\UserinfoWidget::widget(); ?>
        <!-- Info -->
    </div>
    <!-- Widgets End -->
    <!-- Modal  Score -->
        <?=\frontend\widgets\FairWidget::widget(); ?>
    <!-- Modal Score End -->
    <!-- Modal Stock -->
        <?=\frontend\widgets\UserstorageWidget::widget();?>
    <!-- Modal Stock End -->
    <!-- Gide -->
        <?=\frontend\widgets\GamemenuWidget::widget()?>
    <!-- Gide End -->
    <!-- Gide End -->

    <!-- Game -->
    <div class="col-md-6 col-md-offset-3 nones-st">
        <?php
        $last_item = count($items)-1;
        $max_lvl = $items[$last_item]['level'];
        $count_max_lvl = 0;
        foreach($items as $l_id => $item) :
            $ready = false;
            $not_available = false;
            $class = '';
            //создание новых полей при покупке последнего поля
            $new_items = 0;
            if($max_lvl == $item['level'])
            {
                $count_max_lvl += 1;
            }
            if($user->level >= $item['level'])
            {
                if($item['status_id'] == \common\models\LandItem::STATUS_READY_FOR_SOW)
                {
                    $class = 'ready_for_sow';
                    $ready = true;
                }
                elseif($item['status_id'] == \common\models\LandItem::STATUS_SOW)
                {
                    if(time() > $item['time_finish'])
                    {
                        Yii::$app->db->createCommand()
                            ->update('land_items', ['status_id' => \common\models\LandItem::STATUS_PRODUCT_READY], 'land_item_id = :id', ['id' => $item['land_item_id']])
                            ->execute();
                        $class = $item['plant_alias'].'_ready harvest';
                    }
                    else
                    {
                        $class = $item['is_fertilized'] ? $item['plant_alias']. '_sow_f sow' : $item['plant_alias']. '_sow sow for-fertilize';
                    }

                }
                elseif($item['status_id'] == \common\models\LandItem::STATUS_PRODUCT_READY)
                {
                    $class = $item['plant_alias'].'_ready harvest';
                }
                else
                {
                    if($last_item == $l_id)
                    {
                        if($newPage)
                        {
                            $new_items = 1;
                        }
                    }
                    //background zelenyi s tablichkoi
                    $class = 'available2';
                }
            }
            else
            {
                $not_available = true;
                $class = 'not_available';
            }

            ?>
            <div class="pole-<?= $l_id + 1 .' '.$class ?>" data-land-id="<?= $item['land_item_id']?>" data-position="<?= $item['position_number'] ?>" data-alias="<?= $item['plant_alias']?>" data-new="<?= $new_items;?>">
                <a href="#" class="btn buttuns-1 land_cell" aria-expanded="false" data-id="<?= $item['land_item_id']; ?>"></a>
                <?php  if($not_available) : ?>
                    <span class='badge bmd-bg-success for-sale-pole'><?= Yii::t('app', 'Купить с {level} уровня', [
                            'level' => $item['level'],
                        ]) ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <input type="hidden" id="max-lvl-count" data-count="<?= $count_max_lvl;?>" data-max-lvl="<?= $max_lvl; ?>">
    </div>
    <div class="col-md-2 btn-mod-1">
        <div class="btn-group btn-group-justified">
            <a href="#" class="collect_all btn btn-success bmd-ripple-only bmd-ink-grey-400 btn-ink" data-toggle="modal" data-target="#collectAll"><?= Yii::t('app', 'Собрать') ?></a>
            <a href="#" class="seed_all btn btn-success bmd-ripple-only bmd-ink-grey-400 btn-ink" data-toggle="modal" data-target="#feedAll"><?= Yii::t('app', 'Засеять') ?></a>
        </div>
    </div>
    <div class="col-md-2 btn-mod-2">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'maxButtonCount' => 3,
            'firstPageLabel' => true,
            'lastPageLabel' => true,
            'options' => [
                'class' => 'btn-group btn-group-justified',
            ],
        ]);
        ?>
    </div>
    <div class="gide-product">
        <form id="plants_list">
            <label class="prod-pos1"><input data-plant-id = "1" data-alias="wheat" class="prod-radio" type="radio" name="optradio" checked><?= Yii::t('app', 'Пшеница') ?></label>
            <label class="prod-pos2"><input data-plant-id = "2" data-alias="clover" class="prod-radio" type="radio" name="optradio"><?= Yii::t('app', 'Клевер') ?></label>
            <label class="prod-pos3"><input data-plant-id = "3" data-alias="cabbage" class="prod-radio" type="radio" name="optradio"><?= Yii::t('app', 'Капуста') ?></label>
            <label class="prod-pos4"><input data-plant-id = "4" data-alias="beets"  class="prod-radio" type="radio" name="optradio"><?= Yii::t('app', 'Свекла') ?></label>
            <label class="prod-pos5"><input class="prod-check fertilized" value="1" name="fertilized" type="checkbox"><?= Yii::t('app', 'Удобрить') ?></label>
        </form>
    </div>

    <!-- Toast ul start -->
    <ul id="wait-timer" class="bmd-toaster"  data-hide="8" data-hidebutton="false"></ul>
    <!-- Toast ul end -->
    <!--    <button data-toggle="modal" data-target="#myModa"><a>AAA</a></button>-->

    <div class="modal" id="myModa">
        <div class="modal-dialog-f bmd-modal-dialog">
            <div class="modal-content-f">
                <div class="modal-header bmd-bg-ferma">
                    <button type="button" class="close btn-link bmd-flat-btn" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><h4 class="modal-title"><?= Yii::t('app', 'Фермерский дом') ?></h4></center>
                </div>
                <div class="modal-body">
                    <p class="response-answer" style="text-align: center;"></p>
                </div>
                <div class="modal-ferma">
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"><?= Yii::t('app', 'Закрыть') ?></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="collectAll">
        <div class="modal-dialog-f bmd-modal-dialog">
            <div class="modal-content-f">
                <div class="modal-header bmd-bg-ferma">
                    <button type="button" class="close btn-link bmd-flat-btn" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><h4 class="modal-title"><?= Yii::t('app', 'Фермерский дом') ?></h4></center>
                </div>
                <div class="modal-body">
                    <p class="response-answer2"><?= Yii::t('app', 'Вы уверены, что хотите собрать весь урожай?') ?></p>
                </div>
                <div class="modal-ferma">
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"  id="collect_all">&nbsp;&nbsp;<?= Yii::t('app', 'Да') ?>&nbsp;</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"><?= Yii::t('app', 'Нет') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="feedAll">
        <div class="modal-dialog-f bmd-modal-dialog">
            <div class="modal-content-f">
                <div class="modal-header bmd-bg-ferma">
                    <button type="button" class="close btn-link bmd-flat-btn" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><h4 class="modal-title"><?= Yii::t('app', 'Фермерский дом') ?></h4></center>
                </div>
                <div class="modal-body">
                    <p class="response-answer3"><?= Yii::t('app', 'Вы уверены, что хотите засеять все поля?') ?></p>
                </div>
                <div class="modal-ferma">
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"  id="feed_all">&nbsp;&nbsp;<?= Yii::t('app', 'Да') ?>&nbsp;</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"><?= Yii::t('app', 'Нет') ?></button>
                </div>
            </div>
        </div>
    </div>

</div><!-- End wrapper -->
<!-- Game End -->
<!--<div id="preloader"></div>-->
<div class="loader-modal" style="display: none;">
    <div class="center">
        <img alt="" src="/img/loader.gif" />
    </div>
</div>
<!-- Script -->
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/prettify.js"></script>
<script src="/js/main.min.js"></script>
<script src="/js/notify/bootstrap-notify.min.js"></script>
<script src="/js/notifier.js"></script>
<script src="/js/jquery.singleclick.js"></script>

<!-- Script End -->
<script>
    $(document).ready(function() {
//reset reopen user storage
        $("#myStock").on("shown.bs.modal", function () {
            var active = $('#myStock').find('ul>li.active');
            active.removeClass('active');
            $('#myStock').find('ul>li:first').addClass('active');

            var active_tab = $('#myStock').find('div.tab-content>div.active');
            active_tab.removeClass('active');
            active_tab.removeClass('in');
            $('#1').addClass('active');
            $('#1').addClass('in');
        });

        //reset reopen fair
        $("#myModal").on("shown.bs.modal", function () {
            var active = $('#myModal').find('ul>li.active');
            active.removeClass('active');
            $('#myModal').find('ul>li:first').addClass('active');

            var active_tab = $('#myModal').find('div.tab-content>div.active');
            active_tab.removeClass('active');
            active_tab.removeClass('in');
            $('#factory').addClass('active in');
            $('#score4').find('ul>li:first').addClass('active');
            $('#score1').addClass('active');
            $('#score1').addClass('in');
        });
        //переменные для предовтращения множество запросов в базу при обработке предыдущих
        // IS_ENABLED_SOW при посадке
        IS_ENABLED_SOW      = true;

        // IS_ENABLED_HARVEST при сборе урожая
        IS_ENABLED_HARVEST  = true;

        // IS_ENABLED_BUY при покупке земли
        IS_ENABLED_BUY      = true;

        // IS_ENABLED_CHECK при проверке урожая
        IS_ENABLED_CHECK    = true;

        // IS_FERTILIZE  - собрать со всех полей
        IS_FERTILIZE      = true;

        DISABLED_BUY = true;
        DISABLED_BUY_CAKE = true;
        DISABLED_SELL = true;
        DISABLED_SELL_CAKE = true;
        DISABLED_EAT = true;
        DISABLED_BUILD = true;
        DISABLED_RUN = true;
        DISABLED_COLLECT = true;

        $('a.land_cell').on('dblclick', function(e) {

            var element = $(this);
            var parent_div = element.closest('div');
            var land_id = parent_div.data('land-id');
            var plant_alias = parent_div.data('alias');
            var position = parent_div.data('position');
            var is_fertilized = $('.fertilized').is(':checked');
            var plant_checked = $('input[name=optradio]:radio:checked').data('alias');

            if(parent_div.hasClass('harvest')) {
                if (!IS_ENABLED_HARVEST) {
                    return 1;
                }
                else {
                    IS_ENABLED_HARVEST = false;
                }
                if(is_fertilized)
                {
                    is_fertilized = 1;
                }
                else
                {
                    is_fertilized = 0;
                }
                $.ajax({
                    url: "<?= Url::toRoute('/land/collect-saw/') ?>",
                    type: "POST",
                    async: true,
                    data: {
                        'land_id': land_id,
                        'plant_alias': plant_alias,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>",
                        'is_fertilized': is_fertilized
                    }
                }).done(function (response) {
                    $('.response-answer').empty();
                    if (response.status) {
                        parent_div.removeClass('ready_for_sow');
                        parent_div.removeClass(plant_checked+'_ready');
                        parent_div.removeClass('harvest');
                        if(is_fertilized == 1)
                        {
                            parent_div.addClass(plant_checked+'_sow_f');
                        }else
                        {
                            //если не удобрено
                            parent_div.addClass('for-fertilize');
                            //
                            parent_div.addClass(plant_checked+'_sow');
                        }
                        parent_div.attr("data-alias",plant_checked);
                        parent_div.addClass('sow');
                        $('.user_energy').html(response.energy);
                        $('.user_experience').html(response.experience);
                    } else {
                        if(response.step)
                        {
                            $('.user_for_pay').html(response.for_pay);
                            parent_div.removeClass('harvest');
                            parent_div.removeClass(plant_alias + '_ready');
                            parent_div.addClass('ready_for_sow');
                            parent_div.removeClass('open');
                            $('.response-answer').html(response.msg);
                            $('#myModa').modal('show');
                        }else
                        {
                            $('.response-answer').html(response.msg);
                            $('#myModa').modal('show');
                        }
                    }
                    IS_ENABLED_HARVEST = true;
                    return 1;
                });
            }
        });

        //$('body').on('click','a.land_cell', function(){
        $('a.land_cell').on('singleclick', function(){
            var element = $(this);
            var parent_div = element.closest('div');
            var land_id = parent_div.data('land-id');
            var plant_alias = parent_div.data('alias');
            var position = parent_div.data('position');
            var is_fertilized = $('.fertilized').is(':checked');
            //сбор урожая
            if(parent_div.hasClass('harvest'))
            {
                if (!IS_ENABLED_HARVEST) {
                        return 1;
                }
                else {
                    IS_ENABLED_HARVEST = false;
                }

                $.ajax({
                    url: "<?= Url::toRoute('/land/collection/') ?>",
                    type: "POST",
                    async: true,
                    data: {'land_id': land_id, 'alias': plant_alias, '_csrf': "<?= Yii::$app->request->csrfToken ?>"}
                }).done(function (response) {
                    $('.response-answer').empty();
                    if (response.status) {
                        $('.user_for_pay').html(response.for_pay);
                        parent_div.removeClass('harvest');
                        parent_div.removeClass(plant_alias + '_ready');
                        parent_div.addClass('ready_for_sow');
                        parent_div.removeClass('open');
                    } else {
                        $('.response-answer').html(response.msg);
                        $('#myModa').modal('show');
                    }
                    IS_ENABLED_HARVEST = true;
                    return 1;
                });
            }
            // покупка земли
            else if(parent_div.hasClass('available2'))
            {
                if(!IS_ENABLED_BUY)
                {
                    return 1;
                }
                else
                {
                    IS_ENABLED_BUY = false;
                }
                var is_new_items = parent_div.data('new');
                var max_lvl_count = $('#max-lvl-count').data('count');
                var max_lvl = $('#max-lvl-count').data('max-lvl');

                $.ajax({
                    url: "<?= Url::toRoute('/land/land-buy/') ?>",
                    type: "POST",
                    async:true,
                    data: {'max_lvl':max_lvl, 'lvl_count':max_lvl_count, 'is_new':is_new_items, 'land_id': land_id, '_csrf':"<?= Yii::$app->request->csrfToken ?>"}
                }).done(function(response){
                    $('.response-answer').empty();
                    if(response.status){
                        if(is_new_items)
                        {
                            location.reload();
                        }
                        else
                        {
                            $('.user_for_pay').html(response.for_pay);
                            parent_div.removeClass('available2');
                            parent_div.addClass('ready_for_sow');
                            parent_div.removeClass('open');
                            $('.user_energy').html(response.energy);
                            $('.user_experience').html(response.experience);
                        }
                    }else{
                        console.log(response.msg);
                        $('.response-answer').text(response.msg);
                        $('#myModa').modal('show');
                    }
                });
                IS_ENABLED_BUY = true;
                return 1;
            }
            //посадка пшеницы start
            else if(parent_div.hasClass('ready_for_sow'))
            {
                if(!IS_ENABLED_SOW)
                {
                    return 1;
                }
                else
                {
                    IS_ENABLED_SOW = false;
                }

                var plant_checked = $('input[name=optradio]:radio:checked').data('alias');
                var plant_id = $('input[name=optradio]:radio:checked').data('plant-id');
                if(is_fertilized)
                {
                    is_fertilized = 1;
                }
                else
                {
                    is_fertilized = 0;
                }
                $.ajax({
                    url: "<?= Url::toRoute('/land/land-sow/') ?>",
                    type: "POST",
                    async:true,
                    data: {'is_fertilized':is_fertilized, 'plant_id': plant_id, 'land_id': land_id, 'alias':plant_checked, '_csrf':"<?= Yii::$app->request->csrfToken ?>"}
                }).done(function(response){
                    $('.response-answer').empty();
                    if(response.status){
                        parent_div.removeClass('ready_for_sow');
                        if(is_fertilized == 1)
                        {
                            parent_div.addClass(plant_checked+'_sow_f');
                        }else
                        {
                            //если не удобрено
                            parent_div.addClass('for-fertilize');
                            //
                            parent_div.addClass(plant_checked+'_sow');
                        }
                        parent_div.attr("data-alias",plant_checked);
                        parent_div.addClass('sow');
                        $('.user_energy').html(response.energy);
                        $('.user_experience').html(response.experience);
                    }else{
                        console.log(response.msg);
                        $('.response-answer').text(response.msg);
                        $('#myModa').modal('show');
                    }
                });
                IS_ENABLED_SOW = true;
                return 1;
            }
            //удобрение пшеницы для неудобренных полей
            else if(parent_div.hasClass('sow') && parent_div.hasClass('for-fertilize') && is_fertilized)
            {
                if(!IS_FERTILIZE)
                {
                    return 1;
                }
                else
                {
                    IS_FERTILIZE = false;
                }
                $.ajax({
                    url: "<?= Url::toRoute('/land/fertilize/') ?>",
                    type: "POST",
                    async: true,
                    data: {'land_id': land_id, '_csrf': "<?= Yii::$app->request->csrfToken ?>"}
                }).done(function (response) {
                    $('.response-answer').empty();
                    if (response.status) {
                        parent_div.removeClass(response.alias+'_sow');
                        parent_div.removeClass('for-fertilize');
                        parent_div.addClass(response.alias +'_sow_f');
                        $('.user_energy').html(response.energy);
                    } else {
                        $('.response-answer').html(response.msg);
                        $('#myModa').modal('show');
                    }
                    IS_FERTILIZE = true;
                    return 1;
                });

            }
            //проверка урожая на готовность
            else if(parent_div.hasClass('sow'))
            {
                if(!IS_ENABLED_CHECK)
                {
                    return 1;
                }
                else
                {
                    IS_ENABLED_CHECK = false;
                }
                if (typeof intervalID !== 'undefined')
                {
                    clearInterval(intervalID);
                    intervalID = '';
                }

                $('.response-answer').html();
                $.ajax({
                    url: "<?= Url::toRoute('/land/harvest/') ?>",
                    type: "POST",
                    async:true,
                    data: {'land_id': land_id, '_csrf':"<?= Yii::$app->request->csrfToken ?>"}
                }).done(function(response){
                    if(response.status){
                        $('.user_for_pay').html(response.for_pay);
                        parent_div.removeClass('sow');
                        parent_div.removeClass(response.alias+'_sow');
                        parent_div.removeClass(response.alias+'_sow_f');
                        parent_div.addClass('harvest');
                        parent_div.addClass(response.alias+'_ready');
                        $('.user_energy').html(response.energy);
                        $('.user_experience').html(response.experience);
//                        $('.response-answer').html(response.msg);
                    }else{
                        if(response.msg)
                        {
                            $('.response-answer').html(response.msg);
                            $('#myModa').modal('show');
                        }
                        else
                        {
                            var leftStr = "<?= mb_strtolower(Yii::t('app', 'Осталось')) ?>";
                            var hoursStr = "<?= mb_strtolower(Yii::t('app', 'Д')) ?>";
                            var minutesStr = "<?= mb_strtolower(Yii::t('app', 'Час')) ?>";
                            var secondsStr = "<?= mb_strtolower(Yii::t('app', 'Мин')) ?>";
                            var daysStr = "<?= mb_strtolower(Yii::t('app', 'Сек')) ?>";
                            
                            var msg = '<span>' + leftStr + ':&nbsp;</span><br/><span class="afss_day_bv">0</span> ' + daysStr + '.'+
                                '<span class="afss_hours_bv">00</span>&nbsp;' + hoursStr + '.&nbsp;'+
                                '<span class="afss_mins_bv">00</span>&nbsp;' + minutesStr + '.&nbsp;'+
                                '<span class="afss_secs_bv">00&nbsp;</span>&nbsp;' + secondsStr + '.';
                            reSetTime(response.timer);
                            showToast(msg);
                        }
                    }
                    IS_ENABLED_CHECK = true;
                    return 1;
                });
            }

        });


        $('body').on('click','#collect_all', function()
        {
            $.ajax({
                url: "<?= Url::toRoute('/land/collect-all/') ?>",
                type: "POST",
                async:true,
                data: { '_csrf':"<?= Yii::$app->request->csrfToken ?>"},
                beforeSend: function () {
                    $(".loader-modal").show();
                }
            }).done(function(response){
                $('.response-answer').empty();
                if(response.status){
                    if(response.timer >= 7)
                    {
                        $(".loader-modal").hide();
                        location.reload();
                    }
                    else
                    {
                        var timeToHide = (7-response.timer) * 1000;
                        LoaderTimer = setTimeout(function(){ $(".loader-modal").hide();
                            $('#myModa').modal('show');
                            $('.response-answer').html(response.msg);
                            location.reload();
                        }, timeToHide);
                    }
                }else{
                    $(".loader-modal").hide();
                    console.log(response.msg);
                    $('.response-answer').text(response.msg);
                    $('#myModa').modal('show');
                }
            });
        });

        $('body').on('click','#feed_all', function(){
            var plant_alias = $('input[name=optradio]:radio:checked').data('alias');
            var is_fertilized = $('.fertilized').is(':checked');
            if(is_fertilized)
            {
                is_fertilized = 1;
            }
            else
            {
                is_fertilized = 0;
            }
            $.ajax({
                url: "<?= Url::toRoute('/land/feed-all/') ?>",
                type: "POST",
                async:true,
                data: {'is_fertilized':is_fertilized, 'plant_alias': plant_alias, '_csrf':"<?= Yii::$app->request->csrfToken ?>"},
                beforeSend: function () {
                    $(".loader-modal").show();
                }
            }).done(function(response){
                $('.response-answer').empty();
                if(response.status){
                    if(response.timer >= 7)
                    {
                        $(".loader-modal").hide();
                        location.reload();
                    }
                    else
                    {
                        var timeToHide = (7-response.timer) * 1000;
                        LoaderTimer = setTimeout(function(){
                            $(".loader-modal").hide();
                            $('#myModa').modal('show');
                            $('.response-answer').html(response.msg);

                            location.reload();
                        }, timeToHide);
                    }

                }else{
                    $(".loader-modal").hide();
                    $('.response-answer').text(response.msg);
                    $('#myModa').modal('show');
                }
            });

        });

        $('.product-buy').click(function()
        {
            if(!DISABLED_BUY){return 1;}
            else{DISABLED_BUY = false;}
            var id = $(this).parents('div.input-group').find('.product-count').data('id');
            var count = $(this).parents('div.input-group').find('.product-count').val();
            var alias = $(this).parents('div.input-group').find('.product-count').data('alias');
            var energy = $(this).parents('div.input-group').find('.product-count').data('energy');
            var experience = $(this).parents('div.input-group').find('.product-count').data('experience');
            if(Math.floor(count) == count && $.isNumeric(count)) {
                if (count && count > 0) {
                    $.ajax({
                        url: "<?= Url::toRoute('/game/buy/') ?>",
                        type: "POST",
                        async: true,
                        data: {
                            'id': id,
                            'count': count,
                            'alias': alias,
                            'energy': energy,
                            'experience': experience,
                            '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                        }
                    }).done(function (response) {
                        if (response.status) {
                            $('.user_for_pay').html(response.for_pay);
                            $('#' + alias + '_count').html(response.countProduct);
                            $('#' + alias).html(response.alias);
                            $('.user_energy').html(response.energy);
                            $('.user_experience').html(response.experience);
                            if (response.showLevel == true) {
                                response.msg += '<h4>';
                                response.msg += '<?= mb_strtoupper(Yii::t('app', 'Вы достигли')) ?>';
                                response.msg += ' ' + response.newLevel + ' ';
                                response.msg += '<?= mb_strtoupper(Yii::t('app', 'Уровня')) ?>';
                                response.msg += '!!!</h4>';

                                $('#user_lvl').html(response.newLevel);
                                location.reload();
                            }
                            $('#myModa').modal('show');
                            $('.response-answer').html(response.msg);
                        } else {
                            $('#myModa').modal('show');
                            $('.response-answer').html(response.msg);
                        }
                        DISABLED_BUY = true;
                    });
                }
                else {
                    $('#myModa').modal('show');
                    var message = "<?= Yii::t('app', 'Минимальное количество покупки 1') ?>";
                    $('.response-answer').html(message + '!');
                    //alert('Минимальное количество покупки 1!');
                    DISABLED_BUY = true;
                }
            }else{
                $('#myModa').modal('show');
                var message = "<?= Yii::t('app', 'Введите целочисленное число') ?>";
                $('.response-answer').html(message + '!');
                DISABLED_BUY = true;
            }
            return 1;
        });

        $('.buy-cake').click(function(){
            if(!DISABLED_BUY_CAKE){return 1;}
            else{DISABLED_BUY_CAKE = false;}
            var queueId = $('#queueList > tbody tr:first > td:first .queueId').val();
            var productId = $('#queueList > tbody tr:first > td:first .productId').val();
            var userId = $('#queueList > tbody tr:first > td:first .userId').val();
            var price = $('#queueList > tbody tr:first > td:first .price').val();
            var alias = $('#queueList > tbody tr:first > td:first .alias').val();
            var currentCount = parseInt($('#queueList > tbody tr:first').find('.queueCount').html());
            var count =  parseInt($(this).parents('div.input-group').find('.cake-count').val()); //alert(count);
            //console.log(count);
            //return 1;
            if(Math.floor($('.cake-count').val()) == $('.cake-count').val() && $.isNumeric($('.cake-count').val())) {
                if (count && count > 0) {
                    if (currentCount > 0) {
                        if (currentCount >= count) {
                            $.ajax({
                                url: "<?= Url::toRoute('/game/buy-cake/') ?>",
                                type: "POST",
                                async: true,
                                data: {
                                    'queueId': queueId,
                                    'count': count,
                                    'currentCount': currentCount,
                                    'productId': productId,
                                    'userId': userId,
                                    'alias': alias,
                                    '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                                }
                            }).done(function (response) {
                                if (response.status) {
                                    $('.user_for_pay').html(response.for_pay);
                                    $('#' + alias).html(response.alias);
                                    $('#' + alias + '2').html(response.alias); //так как id unic он не подставляет значение в складе
                                    $('#queueList > tbody tr:first').find('.queueCount').html(response.count);
                                    $('#myModa').modal('show');
                                    $('.response-answer').html(response.msg);
                                    if (response.count == 0) {
                                        location.reload();
                                    }
                                } else {
                                    $('#myModa').modal('show');
                                    $('.response-answer').html(response.msg);
                                }
                                DISABLED_BUY_CAKE = true;
                            });
                        } else {
                            $('#myModa').modal('show');
                            var message = "<?= Yii::t('app', 'Максимально доступное количество') ?>";
                            $('.response-answer').html(message + currentCount + '!');
                            //alert('Максимально доступное количество '+currentCount +'!');
                            DISABLED_BUY_CAKE = true;
                        }
                    } else {
                        $('#myModa').modal('show');
                        var message = "<?= Yii::t('app', 'Пирог для продажи отсуствует') ?>";
                        $('.response-answer').html(message + '!');
                        DISABLED_BUY_CAKE = true;
                    }
                }
                else {
                    $('#myModa').modal('show');
                    var message = "<?= Yii::t('app', 'Минимальное количество покупки 1') ?>";
                    $('.response-answer').html(message + '!');
                    DISABLED_BUY_CAKE = true;
                }
            }else{
                $('#myModa').modal('show');
                var message = "<?= Yii::t('app', 'Введите целочисленное число') ?>";
                $('.response-answer').html(message + '!');
                DISABLED_BUY_CAKE = true;
            }
            return 1;
        })

        $('body').on('click','a.product-for-sell', function()
        {
            $.ajax({
                url: "<?= Url::toRoute('/game/product-for-sell/') ?>",
                type: "POST",
                async: true,
                data: {
                    '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                },
            }).done(function (response) {
                if (response.status) {
                    $('#2').html(response.forSell);
                } else {
                    $('#myModa').modal('show');
                    $('.response-answer').html(response.msg);
                }
            });
        });

        $('body').on('click','.product-sell', function()
        {
            if(!DISABLED_SELL){return 1;}
            else{DISABLED_SELL = false;}
            var id = $(this).parents('div.input-group').find('.product-count').data("id");
            var model_name = $(this).parents('div.input-group').find('.product-count').data("model");
            var price_for_sell = $(this).parents('div.input-group').find('.product-count').data("price");
            var min_count = $(this).parents('div.input-group').find('.product-count').data("min_count");
            var alias = $(this).parents('div.input-group').find('.product-count').data("alias");
            var count = $(this).parents('div.input-group').find('.product-count').val();
            var current_count = $(this).parents('div.input-group').find('.product-count').data("current_count"); //alert(current_count);
            if(Math.floor(count) == count && $.isNumeric(count)) {
                if (count && count > 0) {
                    if (current_count >= count) {
                        $.ajax({
                            url: "<?= Url::toRoute('/game/sell/') ?>",
                            type: "POST",
                            async: true,
                            data: {
                                'id': id,
                                'count': count,
                                'current_count': current_count,
                                'model_name': model_name,
                                'min_count': min_count,
                                'alias': alias,
                                'price_for_sell': price_for_sell,
                                '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                            }
                        }).done(function (response) {
                            if (response.status) {
                                $('.user_energy').html(response.energy);
                                $('#' + alias).html(response.count);
                                $('#myModa').modal('show');
                                $('.response-answer').html(response.msg);
                            } else {
                                $('#myModa').modal('show');
                                $('.response-answer').html(response.msg);
                            }
                            DISABLED_SELL = true;
                        });
                    } else {
                        $('#myModa').modal('show');
                        var message = "<?= Yii::t('app', 'У вас недостаточное количество для продажи, минимальное количество продажи') ?>";
                        $('.response-answer').html(message + ' ' + min_count + '!');
                        DISABLED_SELL = true;
                    }
                }
                else {
                    $('#myModa').modal('show');
                    var message = "<?= Yii::t('app', 'Минимальное количество продажи') ?>";
                    $('.response-answer').html(message + ' ' + min_count);
                    DISABLED_SELL = true;
                }
            }else{
                $('#myModa').modal('show');
                var message = "<?= Yii::t('app', 'Введите целочисленное число') ?>";
                $('.response-answer').html(message + '!');
                DISABLED_SELL = true;
            }
            return 1;
        });

        $('body').on('click','.cake-sell', function()
        {
            if(!DISABLED_SELL_CAKE){return 1;}
            else{DISABLED_SELL_CAKE = false;}
            var id = $(this).parents('div.input-group').find('.product-count').data("id");
            var model_name = $(this).parents('div.input-group').find('.product-count').data("model");
            var price_for_sell = $(this).parents('div.input-group').find('.product-count').data("price");
            var min_count = $(this).parents('div.input-group').find('.product-count').data("min_count");
            var alias = $(this).parents('div.input-group').find('.product-count').data("alias");
            var count = $(this).parents('div.input-group').find('.product-count').val();
            var current_count = $(this).parents('div.input-group').find('.product-count').data("current_count"); //alert(current_count);
            var element = $(this)
            if(Math.floor(count) == count && $.isNumeric(count)) {
                if (count && count > 0) {
                    if (current_count >= count) {
                        $.ajax({
                            url: "<?= Url::toRoute('/game/cake-sell/') ?>",
                            type: "POST",
                            async: true,
                            data: {
                                'id': id,
                                'count': count,
                                'current_count': current_count,
                                'model_name': model_name,
                                'min_count': min_count,
                                'alias': alias,
                                'price_for_sell': price_for_sell,
                                '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                            }
                        }).done(function (response) {
                            if (response.status) {
                                element.parents('div.storage').find('#' + alias).html(response.count);
                                $('#myModa').modal('show');
                                $('.response-answer').html(response.msg);
                            } else {
                                $('#myModa').modal('show');
                                $('.response-answer').html(response.msg);
                            }
                            DISABLED_SELL_CAKE = true;
                        });
                    } else {
                        $('#myModa').modal('show');
                        var message = "<?= Yii::t('app', 'У вас недостаточное количество для продажи, минимальное количество продажи') ?>";
                        $('.response-answer').html(message + ' ' + min_count + '!');
                        DISABLED_SELL_CAKE = true;
                    }
                }
                else {
                    $('#myModa').modal('show');
                    var message = "<?= Yii::t('app', 'Минимальное количество продажи') ?>";
                    $('.response-answer').html(message + ' ' + min_count);
                    DISABLED_SELL_CAKE = true;
                }
            }else{
                $('#myModa').modal('show');
                var message = "<?= Yii::t('app', 'Введите целочисленное число') ?>";
                $('.response-answer').html(message + '!');
                DISABLED_SELL_CAKE = true;
            }
            return 1;
        });

        $('.eat').click(function()
        {
            if(!DISABLED_EAT){return 1;}
            else{DISABLED_EAT = false;}
            var alias = $(this).data('alias');
            var count = $('#' + alias).html();
            var id = $(this).data('id');
            var type = $(this).data('type'); //alert(type);
            if(count && count > 0) {
                $.ajax({
                    url: "<?= Url::toRoute('/game/eat/') ?>",
                    type: "POST",
                    async: true,
                    data: {
                        'id': id,
                        'alias': alias,
                        'count': count,
                        'type': type,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                    }
                }).done(function (response) {
                    if (response.status) {
                        $('.user_energy').html(response.user_energy);
                        $('#' + alias).html(response.count);
                        $('#' + alias+'2').html(response.count); //так как id unic он не подставляет значение в складе
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    } else {
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    }
                    DISABLED_EAT = true;
                });
            } else{
                $('#myModa').modal('show');
                var message = "<?= Yii::t('app', 'У вас нет пирогов') ?>";
                $('.response-answer').html(message + '!');
                DISABLED_EAT = true;
            }
            return 1;
        });

        $('body').on('click','a.statistics-fair', function()
        {
            $.ajax({
                url: "<?= Url::toRoute('/game/statistics-fair/') ?>",
                type: "POST",
                async: true,
                data: {
                    '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                },
            }).done(function (response) {
                if (response.status) {
                    $('#score9').html(response.htmlElement);
                    $('table#queueList>tbody').html(response.tbody);
                } else {
                    $('#myModa').modal('show');
                    $('.response-answer').html(response.msg);
                }
            });
        });

        $('body').on('click','a.queuelist-fair', function()
        {
            $.ajax({
                url: "<?= Url::toRoute('/game/queuelist-fair/') ?>",
                type: "POST",
                async: true,
                data: {
                    '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                },
            }).done(function (response) {
                if (response.status) {
                    $('table#queueList>tbody').html(response.tbody);
                } else {
                    $('#myModa').modal('show');
                    $('.response-answer').html(response.msg);
                }
            });
        });

        $('body').on('click','a.product-for-sell', function()
        {
            $.ajax({
                url: "<?= Url::toRoute('/game/product-for-sell/') ?>",
                type: "POST",
                async: true,
                data: {
                    '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                },
            }).done(function (response) {
                if (response.status) {
                    $('#2').html(response.forSell);
                } else {
                    $('#myModa').modal('show');
                    $('.response-answer').html(response.msg);
                }
            });
        });

    //toast start
    function showToast(msg) {
//            var a = "New message at " + (new Date).toLocaleTimeString();
        $("#wait-timer").toaster({
            styleclass: "info",
            bounce: "left",
            message: msg
        })
    }
    //toast end

    //timer start
    var remain_bv = 0;
    function parseTime_bv(timestamp) {
        if (timestamp < 0) timestamp = 0;

        var day = Math.floor((timestamp / 60 / 60) / 24);
        var hour = Math.floor(timestamp / 60 / 60);
        var mins = Math.floor((timestamp - hour * 60 * 60) / 60);
        var secs = Math.floor(timestamp - hour * 60 * 60 - mins * 60);
        var left_hour = Math.floor((timestamp - day * 24 * 60 * 60) / 60 / 60);

        $('span.afss_day_bv').text(day);
        $('span.afss_hours_bv').text(left_hour);

        if (String(mins).length > 1)
            $('span.afss_mins_bv').text(mins);
        else
            $('span.afss_mins_bv').text("0" + mins);
        if (String(secs).length > 1)
            $('span.afss_secs_bv').text(secs);
        else
            $('span.afss_secs_bv').text("0" + secs);
    }


    function reSetTime(time) {
        remain_bv = time;
        intervalID = setInterval(function () {
            remain_bv = remain_bv - 1;
            parseTime_bv(remain_bv);
            //if (remain_bv == 0) {
            // nothing
            //}
        }, 1000);
    }

    //timer end

    });
    //notify status: 1 - news; 2 - mails, 3 - msgs
    UPDATE_TYPE = 1;
    function checkUpdates()
    {
        if(UPDATE_TYPE == 3)
        {
            url = "<?php echo \Yii::$app->getUrlManager()->createUrl('news/get-notify') ?>";
            UPDATE_TYPE = 1;
        }
        else
        {
            if(UPDATE_TYPE == 2)
            {
                url = "<?= Url::toRoute('news/notify-mail') ?>";
            }
            else
            {
                url = "<?= Url::toRoute('news/notify-message') ?>";
            }
            UPDATE_TYPE += 1;
        }
        $.ajax({
            url: url,
            type: "POST",
            async:true,
            data: { '_csrf': "<?= Yii::$app->request->csrfToken ?>" }
        }).done(function(response){
            if(response.status)
            {
                showNotify(response.title, response.msg, response.url);
            }
        });
    }
</script>
</body>
</html>