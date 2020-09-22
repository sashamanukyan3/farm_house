<?php
session_start();
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

if(isset($_GET['ref-id'])) {
    $ridd = intval($_GET['ref-id']);
    setcookie("ref-id",$ridd,time());
}

if(!isset($_SESSION['referal_url'])){
    if(isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER["HTTP_REFERER"], FILTER_VALIDATE_URL)) {
        $parse =  parse_url($_SERVER["HTTP_REFERER"]);
        //if($parse['host'] != 'bitmoneyfarm.club' && $parse['host'] != 'www.bitmoneyfarm.club' && !empty($parse['host'])){
            $_SESSION['referal_url']=$_SERVER["HTTP_REFERER"];
        //}
    }
}


$application = new yii\web\Application($config);
$application->run();
//echo 'Проводим дополнительные технические работы, пожалуйста ожидайте. Все новости '."<a href='http://vk.com'>на странице ВК</a>";