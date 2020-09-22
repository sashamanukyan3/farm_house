<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'sourceLanguage' => 'en-US',
    'language' => 'ru',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'languages',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'enableCsrfValidation' => true,
            'baseUrl' => '',
            'class' => 'common\components\Request',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'userCounter' => [
            'class' => 'frontend\components\UserCounter',
            'tableUsers' => 'pcounter_users',
            'tableSave' => 'pcounter_save',
            'autoInstallTables' => true,
            'onlineTime' => 10, // min
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => 'frontendUser1',
            ]
        ],
        'session' => [
            'name' => 'PHPFRONTSESSION3',
            'cookieParams' => [
                //'domain' => '.bitmoneyfarm.club',
                //'domain' => '.ferma.local',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'class' => 'common\components\UrlManager',
            'rules' => [
                'languages' => 'languages/default/index',

                '<controller:(profile)>/view/<username:[A-Za-z0-9 -_.]+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                'register' => 'site/signup',
                'resend' => 'user/registration/resend',
                'confirm/<id:\d+>/<token:\w+>' => 'user/registration/confirm',
                'login' => 'site/login',
                'faq'=> 'site/faq',
                'tos'=>'site/tos',
                'online'=>'site/online',
                'news'=>'news/index',
                'top'=>'site/top',
                'game'=>'game/index',
                'charity'=>'site/charity',
                'logout' => 'site/logout',
                'recovery' => 'user/recovery/request',
                'reset/<id:\d+>/<token:\w+>' => 'user/recovery/reset',
                'contact'=> 'site/contact',
                'exchange'=> 'site/exchange'
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
    'params' => $params,

    'modules' => [
        'languages' => [
            'class' => 'common\modules\languages\Module',
            'languages' => [
                'English' => 'en',
                'Русский' => 'ru',
            ],
            'defaultLanguage' => 'ru',
            'showDefault' => true,
        ],
    ],
];
