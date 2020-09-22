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
                    <img class="game_ava set" src="/img/icon/10.png"/>
                </div>
                <div class="col-md-8 nonestyle">
                    <div class="">
                        <center><h3 class="ferma-gide-menu ttinfo"><?= Yii::t('app', 'Пирог с мясом') ?>
                            <a href="#" class="tooltip-info">
                                [?]
                                <span class="custom info"><em><?= Yii::t('app', 'Информация') ?></em>
                                    <?= Yii::t('app', 'Пекарня пирог с мясом') ?><br>
                                    <?= Yii::t('app', 'Для приготовления 200 пирогов необходимо 70 теста и 200 фарша') ?>.<br>
                                    <?= Yii::t('app', 'Время переработки: 24 часа') ?>.<br>
                                    <?= Yii::t('app', 'Каждый запуск забирает 1100ед. энергии и дает 10 ед. опыта') ?>.<br>
                                    <?= Yii::t('app', 'Каждый сбор забирает 1700 ед. энергии и дает 10 ед. опыта') ?>.<br>
                                </span>
                            </a>
                        </h3></center>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gid End -->
        <?=\frontend\widgets\UserinfoWidget::widget(); ?>
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
    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="myZagon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modalpes ples">
            <div class="modal_content bgmodalses">
                <div class="modal-header">
                    <div class="col-md-1 col-mod-1">
                        <button type="button" class="close closes mod" data-dismiss="modal" aria-hidden="true"><?= Yii::t('app', 'Выход') ?></button>
                    </div>
                </div>
                <div class="modal-body modal_padding_top chicken_modal">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <!-- Game -->
    <div class="col-md-6 col-md-offset-3 nones-st">
        <?php foreach($factoryItems as $id => $factoryItem) : ?>
            <?php
            $class = '';
            $click = '';
            $ready = false;
            $not_available = false;
            $productReady = 0;

            $status = 'bmd-bg-danger';

            $tomato = \common\models\MeatBakery::find()->where(['item_id' => $factoryItem['item_id']])->andWhere(['status_id'=>\common\models\MeatBakery::STATUS_RUN])->all();
            $tomato = count($tomato);
            if($tomato>0) {
                $status = 'bmd-bg-warning';
            }

            $green = \common\models\MeatBakery::find()->where(['item_id' => $factoryItem['item_id']])->andWhere(['status_id'=>\common\models\MeatBakery::STATUS_READY_PRODUCT])->all();
            $green = count($green);
            if($green>0){
                $status = 'bmd-bg-success'; //green
            }

            if($factoryItem['level'] <= $user->level)
            {
                if($factoryItem['status_id'] == \common\models\MeatBakery::STATUS_READY)
                {
                    $class = 'ready_meat_bakery';
                    $ready = true;
                    $click = 'run_bakery';
                }
                elseif($factoryItem['status_id'] == \common\models\MeatBakery::STATUS_RUN){
                    $class = 'ready_meat_bakery';
                    $ready = true;
                    $click = 'check';
                    $productReady = 200;
                }
                elseif($factoryItem['status_id'] == \common\models\MeatBakery::STATUS_READY_PRODUCT){
                    $class = 'ready_meat_bakery';
                    $ready = true;
                    $click = 'collect_product';
                    $productReady = 200;
                }
                else
                {
                    $class = 'available';
                    $click = 'build_bakery';
                }
            }
            else
            {
                $not_available = true;
                $class = 'not_available';
            }
            ?>
            <div class="paddock-chicken pole-<?=$id + 1 .' '.$class ?>">
                <a href="#" data-toggle="dropdown" class="btn buttuns-1 <?=$click;?>" aria-expanded="false"
                   data-pole="pole-<?=$id + 1;?>" data-position="<?=$id + 1;?>" data-level="<?=$factoryItem['level'];?>"  data-item_id="<?=$factoryItem['item_id']; ?>"></a>
                <?php if($ready): ?><span class="badge <?=$status;?> status" id="status_<?=$id + 1;?>"><?=$productReady?></span><?php endif;?>
                <?php  if($not_available) : ?>
                    <span class='badge bmd-bg-success for-sale-pole'><?= Yii::t('app', 'Доступен с {level} уровня', [
                        'level' => $factoryItem['level'],
                    ]) ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-2 btn-mod-1">
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
    <!--<button data-toggle="modal" data-target="#myModa"><a>AAA</a></button>-->
    <div class="modal" id="myModa">
        <div class="modal-dialog-f bmd-modal-dialog">
            <div class="modal-content-f">
                <div class="modal-header bmd-bg-ferma">
                    <button type="button" class="close btn-link bmd-flat-btn" data-dismiss="modal" aria-hidden="true">×</button>
                    <center><h4 class="modal-title"><?= Yii::t('app', 'Фермерский дом') ?></h4></center>
                </div>
                <div class="modal-body">
                    <p class="response-answer"></p>
                </div>
                <div class="modal-ferma">
                    <button type="button" class="btn btn-success bmd-ripple bmd-ink-grey-400 btn-fer" data-dismiss="modal"><?= Yii::t('app', 'Закрыть') ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Game End -->
    <!-- Toast ul start -->
    <ul id="wait-timer" class="bmd-toaster"  data-hide="8" data-hidebutton="false"></ul>
    <!-- Toast ul end -->
    <!--<div id="preloader"></div>-->
    <div class="loader-modal" style="display: none;">
        <div class="center">
            <img alt="" src="/img/loader.gif" />
        </div>
    </div>
</div><!-- End wrapper -->
    <!-- Script -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.easing.min.js"></script>
    <script src="/js/prettify.js"></script>
    <script src="/js/main.min.js"></script>
    <script src="/js/notify/bootstrap-notify.min.js"></script>
    <script src="/js/notifier.js"></script>
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
            DISABLED_BUY = true;
            DISABLED_BUY_CAKE = true;
            DISABLED_SELL = true;
            DISABLED_SELL_CAKE = true;
            DISABLED_EAT = true;
            DISABLED_BUILD = true;
            DISABLED_RUN = true;
            DISABLED_COLLECT = true;
            DISABLED_CHECK = true;

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
            })


            $('body').on('click','a.build_bakery', function()
            {
                if(!DISABLED_BUILD){return 1;}
                else{DISABLED_BUILD = false;}
                var item_id = $(this).data('item_id');
                var pole = $(this).data('pole');
                var level = $(this).data('level');
                var position = $(this).data('position');
                var modelName = 'MeatBakery';
                $.ajax({
                    url: "<?= Url::toRoute('/bakery/build-bakery/') ?>",
                    type: "POST",
                    async: true,
                    data: {
                        'item_id': item_id,
                        'level': level,
                        'pole': pole,
                        'modelName': modelName,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                    }
                }).done(function (response) {
                    if (response.status) {
                        var htmlElement = '';
                        $('.'+pole).removeClass('available');
                        $('.'+pole).addClass('ready_meat_bakery');
                        htmlElement += '<span class="badge bmd-bg-danger status " id="status_'+position+'">0</span>';
                        $('.'+pole).append(htmlElement);
                        $('.'+pole+'>a').removeClass('build_bakery');
                        $('.'+pole+'>a').addClass('run_bakery');
                        if(pole == 'pole-9'){location.reload();}
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    } else {
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    }
                    DISABLED_BUILD = true;
                    return 1;
                });
            });

            $('body').on('click','a.run_bakery', function()
            {
                if(!DISABLED_RUN){return 1;}
                else{DISABLED_RUN = false;}
                var item_id = $(this).data('item_id');
                var position = $(this).data('position');
                var pole = $(this).data('pole');
                var modelName = 'MeatBakery';
                //alert(position);
                $.ajax({
                    url: "<?= Url::toRoute('/bakery/run-bakery/') ?>",
                    type: "POST",
                    async: true,
                    data: {
                        'item_id': item_id,
                        'modelName': modelName,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                    }
                }).done(function (response) {
                    if (response.status) {
                        $('.'+pole+'>a').removeClass('run_bakery');
                        $('.'+pole+'>a').addClass('check');
                        $('#status_'+position).attr('style', 'background-color: #ff9800!important;');
                        $('#status_'+position).html(200);
                        $('.user_energy').html(response.energy);
                        $('.user_experience').html(response.exp);
                        $('#cakewithmeat').html(response.cakewithmeat);
                        $('#cakewithcheese').html(response.cakewithcheese);
                        $('#cakewithcurd').html(response.cakewithcurd);
                        if(response.showLevel == true){
                            response.msg += '<h4>';
                            response.msg += '<?= mb_strtoupper(Yii::t('app', 'Вы достигли')) ?>';
                            response.msg += ' ' + response.newLevel + ' ';
                            response.msg += "<?= mb_strtoupper(Yii::t('app', 'Уровня')) ?>";
                            response.msg += '!!!</h4>';

                            $('#user_lvl').html(response.newLevel);
                        }
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    } else {
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    }
                    DISABLED_RUN = true;
                    return 1;
                });
            });

            $('body').on('click','a.collect_product', function()
            {
                if(!DISABLED_COLLECT){return 1;}
                else{DISABLED_COLLECT = false;}
                var item_id = $(this).data('item_id');
                var position = $(this).data('position');
                var pole = $(this).data('pole');
                var modelName = 'MeatBakery';
                //alert(position);
                $.ajax({
                    url: "<?= Url::toRoute('/bakery/collect-product/') ?>", //controller bakery
                    type: "POST",
                    async: true,
                    data: {
                        'item_id': item_id,
                        'modelName': modelName,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                    }
                }).done(function (response) {
                    if (response.status) {
                        $('.user_energy').html(response.energy);
                        $('.user_experience').html(response.exp);
                        if(response.label == true){
                            $('.'+pole).removeClass('ready_meat_bakery');
                            $('.'+pole).addClass('available');
                            $('.'+pole+'>a').addClass('build_bakery');
                            $('#status_'+position).attr('style', 'display: none !important;');
                        }else {
                            $('.'+pole+'>a').addClass('run_bakery');
                            $('#status_' + position).attr('style', 'background-color: #f44336!important;');
                            $('#status_' + position).html(0);
                        }
                        $('.'+pole+'>a').removeClass('collect_product');
                        $('#cakewithmeat_for_sell').html(response.cakewithmeat_for_sell);
                        $('#cakewithcheese_for_sell').html(response.cakewithcheese_for_sell);
                        $('#cakewithcurd_for_sell').html(response.cakewithcurd_for_sell);
                        if(response.showLevel == true){
                            response.msg += '<h4>';
                            response.msg += "<?= mb_strtoupper(Yii::t('app', 'Вы достигли')) ?>";
                            response.msg += ' ' + response.newLevel + ' ';
                            response.msg += "<?= mb_strtoupper(Yii::t('app', 'Уровня')) ?>";
                            response.msg += '!!!</h4>';

                            $('#user_lvl').html(response.newLevel);
                        }
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    } else {
                        $('#myModa').modal('show');
                        $('.response-answer').html(response.msg);
                    }
                    DISABLED_COLLECT = true;
                    return 1;
                });
            });

            $('body').on('click','a.check', function()
            {
                if(!DISABLED_CHECK){return 1;}
                else{DISABLED_CHECK = false;}
                if (typeof intervalID !== 'undefined')
                {
                    clearInterval(intervalID);
                    intervalID = '';
                }
                var item_id = $(this).data('item_id');
                var position = $(this).data('position');
                var pole = $(this).data('pole');
                var modelName = 'MeatBakery';
                //alert(position);
                $.ajax({
                    url: "<?= Url::toRoute('/bakery/check/') ?>",
                    type: "POST",
                    async: true,
                    data: {
                        'item_id': item_id,
                        'modelName': modelName,
                        '_csrf': "<?= Yii::$app->request->csrfToken ?>"
                    }
                }).done(function (response) {
                    if (response.status) {
                        location.reload();
                    } else {
                        var nextHarvestingStr = "<?= Yii::t('app', 'До следующего сбора') ?>";
                        var hoursStr = "<?= mb_strtolower(Yii::t('app', 'Д')) ?>";
                        var minutesStr = "<?= mb_strtolower(Yii::t('app', 'Час')) ?>";
                        var secondsStr = "<?= mb_strtolower(Yii::t('app', 'Мин')) ?>";
                        var daysStr = "<?= mb_strtolower(Yii::t('app', 'Сек')) ?>";
                        var harvestingsQty = "<?= Yii::t('app', 'Количество сборов') ?>";

                        var msg = '<span>' + nextHarvestingStr + ':&nbsp;</span><br/><span class="afss_day_bv">0</span> ' + daysStr + '.'+
                            '<span class="afss_hours_bv">00</span>&nbsp;' + hoursStr + '.&nbsp;'+
                            '<span class="afss_mins_bv">00</span>&nbsp;' + minutesStr + '.&nbsp;'+
                            '<span class="afss_secs_bv">00&nbsp;</span>&nbsp;' + secondsStr + '.'+ '<br/>'+
                            harvestingsQty + ': ' + response.count;
                        reSetTime(response.timer);
                        showToast(msg);
                    }
                    DISABLED_CHECK = true;
                    return 1;
                });
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