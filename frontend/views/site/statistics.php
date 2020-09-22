<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.02.2016
 * Time: 11:30
 */
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">
<?php $this->registerJsFile(Yii::$app->getUrlManager()->baseUrl .'/js/highcharts/highcharts.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->getUrlManager()->baseUrl .'/js/highcharts/exporting.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::$app->getUrlManager()->baseUrl .'/js/highcharts/data.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <h4 style="text-align:center;"><?= Yii::t('app', 'Статистика') ?></h4>
            <?php
            $new = [];
            foreach ($newUsers as $index => $newUser) {
                //echo '<pre>'; var_dump($newUsers); die();
                //$signupDate = new DateTime($newUser['signup_date']);
                $formattedData = date('Y-m-d', $newUser['signup_date']);
                $new[$formattedData][$index] = $newUser;

            }//echo '<pre>'; var_dump($newUsers); die();
            foreach($new as $i => $n)
            {
                $count = 0;
                foreach($n as $k=>$j)
                {
                    $count ++;
                }
                $new[$i]['count'] = $count;
            }
            //получаем количество
                $chickens = explode(':', $statistics->all_bought_chickens)[0];
                $bulls = explode(':', $statistics->all_bought_bulls)[0];
                $goats = explode(':', $statistics->all_bought_goats)[0];
                $cows = explode(':', $statistics->all_bought_cows)[0];
                $all = $chickens+$bulls+$goats+$cows; //общее количество
                //количество в процентах
            if($all != 0) {
                $chickens = sprintf("%.2f", ($chickens * 100) / $all);
                $bulls = sprintf("%.2f", ($bulls * 100) / $all);
                $goats = sprintf("%.2f", ($goats * 100) / $all);
                $cows = sprintf("%.2f", ($cows * 100) / $all);
            }
                //получаем количество
                $lands = explode(':', $statistics->all_bought_lands)[0];
                $paddockChickens = explode(':', $statistics->all_bought_paddock_chickens)[0];
                $paddockBulls = explode(':', $statistics->all_bought_paddock_bulls)[0];
                $paddockGoats = explode(':', $statistics->all_bought_paddock_goats)[0];
                $paddockCows = explode(':', $statistics->all_bought_paddock_cows)[0];
                $all = $lands+$paddockChickens+$paddockBulls+$paddockGoats+$paddockCows; //общее количество
                //количество в процентах
            if($all != 0) {
                $lands = sprintf("%.2f", ($lands * 100) / $all);
                $paddockChickens = sprintf("%.2f", ($paddockChickens * 100) / $all);
                $paddockBulls = sprintf("%.2f", ($paddockBulls * 100) / $all);
                $paddockGoats = sprintf("%.2f", ($paddockGoats * 100) / $all);
                $paddockCows = sprintf("%.2f", ($paddockCows * 100) / $all);
            }
                $factoryDough = explode(':', $statistics->all_bought_factory_dough)[0];
                $factoryMince = explode(':', $statistics->all_bought_factory_mince)[0];
                $factoryCheese = explode(':', $statistics->all_bought_factory_cheese)[0];
                $factoryCurd = explode(':', $statistics->all_bought_factory_curd)[0];
                $allFactory = $factoryDough+$factoryMince+$factoryCheese+$factoryCurd; //общее количество
            if($allFactory != 0) {
                $factoryDough = sprintf("%.2f", ($factoryDough * 100) / $allFactory);
                $factoryMince = sprintf("%.2f", ($factoryMince * 100) / $allFactory);
                $factoryCheese = sprintf("%.2f", ($factoryCheese * 100) / $allFactory);
                $factoryCurd = sprintf("%.2f", ($factoryCurd * 100) / $allFactory);
            }
                $bakeryMeat = explode(':', $statistics->all_bought_meat_bakery)[0];
                $bakeryCheese = explode(':', $statistics->all_bought_cheese_bakery)[0];
                $bakeryCurd = explode(':', $statistics->all_bought_curd_bakery)[0];
                $allBakery = $bakeryMeat+$bakeryCheese+$bakeryCurd; //общее количество
            if($allBakery != 0) {
                $bakeryMeat = sprintf("%.2f", ($bakeryMeat * 100) / $allBakery);
                $bakeryCheese = sprintf("%.2f", ($bakeryCheese * 100) / $allBakery);
                $bakeryCurd = sprintf("%.2f", ($bakeryCurd * 100) / $allBakery);
            }

            ?>
            <div id="containerPeople" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
            <div id="containerAnimals" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
            <div id="containerPaddock" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
            <div id="containerFactory" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
            <div id="containerBakery" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto 20px auto"></div>

        </div>
    </div>
</div>

<script>
    $(function () {
        var chickens = parseFloat('<?php echo $chickens;?>');
        var bulls = parseFloat('<?php echo $bulls;?>');
        var goats = parseFloat('<?php echo $goats;?>');
        var cows = parseFloat('<?php echo $cows;?>');

        var lands = parseFloat('<?php echo $lands;?>');
        var paddockChickens = parseFloat('<?php echo $paddockChickens;?>');
        var paddockBulls = parseFloat('<?php echo $paddockBulls;?>');
        var paddockGoats = parseFloat('<?php echo $paddockGoats;?>');
        var paddockCows = parseFloat('<?php echo $paddockCows;?>');

        var factoryDough = parseFloat('<?php echo $factoryDough;?>');
        var factoryMince = parseFloat('<?php echo $factoryMince;?>');
        var factoryCheese = parseFloat('<?php echo $factoryCheese;?>');
        var factoryCurd = parseFloat('<?php echo $factoryCurd;?>');

        var bakeryMeat = parseFloat('<?php echo $bakeryMeat;?>');
        var bakeryCheese = parseFloat('<?php echo $bakeryCheese;?>');
        var bakeryCurd = parseFloat('<?php echo $bakeryCurd;?>');
        $('#containerPaddock').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: "<?= Yii::t('app', 'Куплено Загонов') ?>"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: "<?= Yii::t('app', 'Куплено') ?>",
                colorByPoint: true,
                data: [{
                    name: "<?= Yii::t('app', 'Полей') ?>",
                    y: lands
                }, {
                    name: "<?= Yii::t('app', 'Загон кур') ?>",
                    y: paddockChickens,
                    sliced: true,
                    selected: true
                }, {
                    name: "<?= Yii::t('app', 'Загон бычков') ?>",
                    y: paddockBulls
                }, {
                    name: "<?= Yii::t('app', 'Загон коз') ?>",
                    y: paddockGoats
                }, {
                    name: "<?= Yii::t('app', 'Загон коров') ?>",
                    y: paddockCows
                }]
            }]
        });

        $('#containerFactory').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: "<?= Yii::t('app', 'Куплено Фабрик') ?>"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: "<?= Yii::t('app', 'Куплено') ?>",
                colorByPoint: true,
                data: [{
                    name: "<?= Yii::t('app', 'Фабрика теста') ?>",
                    y: factoryDough
                }, {
                    name: "<?= Yii::t('app', 'Фабрика фарша') ?>",
                    y: factoryMince,
                    sliced: true,
                    selected: true
                }, {
                    name: "<?= Yii::t('app', 'Фабрика сыра') ?>",
                    y: factoryCheese
                }, {
                    name: "<?= Yii::t('app', 'Фабрика творога') ?>",
                    y: factoryCurd
                }]
            }]
        });

        $('#containerBakery').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: "<?= Yii::t('app', 'Куплено пекарний') ?>"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: "<?= Yii::t('app', 'Куплено') ?>",
                colorByPoint: true,
                data: [{
                    name: "<?= Yii::t('app', 'Пекарня пирога с мясом') ?>",
                    y: bakeryMeat
                }, {
                    name: "<?= Yii::t('app', 'Пекарня пирога с сыром') ?>",
                    y: bakeryCheese,
                    sliced: true,
                    selected: true
                }, {
                    name: "<?= Yii::t('app', 'Пекарня пирога с творогом') ?>",
                    y: bakeryCurd
                }]
            }]
        });

        // Create the chart
        $('#containerAnimals').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: "<?= Yii::t('app', 'Куплено животных') ?>"
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: "<?= Yii::t('app', 'Общее количество животных') ?>"
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b><br/>'
            },

            series: [{
                name: "<?= Yii::t('app', 'Куплено') ?>",
                colorByPoint: true,
                data: [{
                    name: "<?= Yii::t('app', 'Кур') ?>",
                    y: chickens,
                }, {
                    name: "<?= Yii::t('app', 'Бычков') ?>",
                    y: bulls,
                }, {
                    name: "<?= Yii::t('app', 'Коз') ?>",
                    y: goats,
                }, {
                    name: "<?= Yii::t('app', 'Коров') ?>",
                    y: cows,
                }]
            }],
        });

        $('#containerPeople').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: "<?= Yii::t('app', 'Новых пользователей за последний месяц') ?>"
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: "<?= Yii::t('app', 'Количество пользователей') ?>"
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: "<?= Yii::t('app', 'Количество пользователей') ?>" + ': <b>{point.y}</b>'
            },
            series: [{
                name: 'Population',
                data:[
                    <?php
                     $countNew = count($new);
                     $int = 0;
                    foreach($new as $month => $count):
                        $int += 1 ?>
                        ['<?=$month?>', <?=$count['count']?>]
                        <?php if($int != $countNew) echo ','; ?>
                    <?php endforeach; ?>

                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });

    });
</script>