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
                    <img class="game_ava set" src="/img/icon/0.png"/>
                </div>
                <div class="col-md-8 nonestyle">
                    <div class="">
                        <center><h3><?= Yii::t('app', 'Ферма') ?></h3></center>
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
                <div class="modal-body modal_padding_top">
                    <div class="zagon-1">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-2">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-3">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-4">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-5">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-6">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-7">
                        <div class="click-z">
                        </div>
                    </div>
                    <div class="zagon-8">
                        <div class="click-z">
                        </div>
                        <span class="label-s">12</span>
                    </div>
                    <div class="zagon-9">
                        <div class="click-z">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <div class="col-md-6 col-md-offset-3 nones-st">
       
    </div>
    <!--<div id="preloader"></div>-->
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