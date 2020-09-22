<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl .'/js/jquery.min.js', ['depends' => [\yii\web\JqueryAsset::className()],'position'=>\yii\web\View::POS_HEAD]); ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl .'/js/highcharts/highcharts.js'); ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl .'/js/highcharts/exporting.js'); ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl .'/js/highcharts/data.js'); ?>
<?php
$new = [];
foreach ($payIn as $index => $newUser) {
    $formattedData = date('Y-m-d', $newUser['created']);
    $new[$formattedData][$index] = $newUser;
}
foreach($new as $i => $n)
{
    $count = 0;
    foreach($n as $k=>$j)
    {
        $count = $j['amount'];
    }
    $new[$i]['count'] = $count;
}

$pI = [];
foreach ($payOut as $index => $newUser) {
    $formattedData = date('Y-m-d', $newUser['created_at']);
    $pI[$formattedData][$index] = $newUser;
}
foreach($pI as $i => $n)
{
    $count = 0;
    foreach($n as $k=>$j)
    {
        $count = $j['amount'];
    }
    $pI[$i]['count'] = $count;
}

?>
<div id="containerPeople" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>

<div id="containerIn" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>

<script>
    $(document).ready(function(){
        $('#containerPeople').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Новых пополнений за последний месяц'
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
                    text: 'Сумма пополнений'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Пополнения: <b>{point.y}</b>'
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


        $('#containerIn').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Вывод за последний месяц'
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
                    text: 'Сумма вывода'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Вывод: <b>{point.y}</b>'
            },
            series: [{
                name: 'Population',
                data:[
                    <?php
                    $countNew = count($pI);
                    $int = 0;
                    foreach($pI as $month => $count):
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
    })
</script>