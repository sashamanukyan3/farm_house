<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//      'css/bootstrap.css',
//      'css/charitable.css',
//      'css/animate.css',
//      'css/flaticon.css',
//      'https://fonts.googleapis.com/icon?family=Material+Icons',
//      'css/prettify.css',
//      'css/main.css',
//      'css/style.css',
//      'css/passhow.css',
//      'css/style.user.css',
//      'css/chat.css',
//      'css/gift.css',
//      'css/bonus.css',
//      'css/support.css',
//      'css/reflink.css',
//      'css/news.css',
//      'js/gritter/css/jquery.gritter.css',
//      'css/stylesheet.css',
//      'css/friendlist.css',
//      'css/banned.css',
      'css/redesign/styles.css',
    ];
    public $js = [
//        'js/jquery.min.js',
//        'js/jquery.easing.min.js',
//        'js/attachers.js',
        'js/redesign/libs.js',
        'js/redesign/main.js',

    ];
//    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
    ];
}
