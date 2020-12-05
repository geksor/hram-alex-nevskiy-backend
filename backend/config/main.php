<?php

use yii\filters\AccessControl;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'homeUrl' => '/admin',
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'rules' => [
                'login' => 'site/login',
                'contact' => 'site/contact',
                'history' => 'site/history',
                'library' => 'site/library',
                'school' => 'site/school',
                'shop' => 'site/shop',
                'sisterhood' => 'site/sisterhood',
                'private-policy' => 'site/private-policy',
                'create-gallery-history' => 'site/create-gallery-history',
                'create-gallery-library' => 'site/create-gallery-library',
                'create-gallery-shop' => 'site/create-gallery-shop',
                'create-gallery-school' => 'site/create-gallery-school',
                'create-gallery-sisterhood' => 'site/create-gallery-sisterhood',
                'send-notice' => 'site/send-notice',
                '<controller>' => '<controller>/index',
                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
    'language' => 'ru-RU',
];
