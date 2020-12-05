<?php

use yii\filters\AccessControl;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'homeUrl' => '/api',
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
              'application/json' => 'yii\web\JsonParser',
              'text/xml' => 'yii\web\XmlParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false,
        ],
        'response' => [
            'format' => 'json',
            'formatters' => [
              'json' => [
                  'class' => 'yii\web\JsonResponseFormatter',
                  'prettyPrint' => YII_DEBUG,
                  'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
              ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'POST /pay-notification' => 'site/pay-notification',
                'POST /auth' => 'site/login',
                'POST /signup' => 'site/signup',
                'GET /verify-code' => 'site/verify-code',
                'GET /resend-code' => 'site/resend-code',
                'POST /request-password-reset' => 'site/request-password-reset',
                'GET /chat-subscrib' => 'site/chat-subscrib',
                'GET /no-reed' => 'chat/no-reed',
                'OPTIONS /no-reed' => 'chat/options',

                'PUT profile/<id:\d+>' => 'profile/update',
                'OPTIONS profile' => 'profile/options',
                'OPTIONS profile/<id:\d+>' => 'profile/options',

                'POST <_c:change-password>' => '<_c>/index',
                'POST <_c:chat>' => '<_c>/create',
                'PUT <_c:chat>' => '<_c>/set-reed',

                'POST <_c:pay-service>' => '<_c>/create',
                'GET <_c:pay-service>/<id:\d+>' => 'site/service-pay-check',
                'GET <_a:service-pay-check>/<id:\d+>' => 'site/<_a>',
                'GET <_a:service-pay-check-on-exit>/<id:\d+>' => 'site/<_a>',

                'POST <_c:donate>' => '<_c>/create',
                'GET <_a:donate-pay-check>/<id:\d+>' => 'site/<_a>',
                'GET <_a:donate-pay-check-on-exit>/<id:\d+>' => 'site/<_a>',

                'OPTIONS <_c:[\w-]+>' => '<_c>/options',
                'OPTIONS <_c:[\w-]+>/<id:\d+>' => '<_c>/options',
                'OPTIONS <_c:[\w-]+>/<_a:[\w-]+>' => '<_c>/options',
                'OPTIONS <_c:[\w-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/options',

                '<_c:[\w-]+>' => '<_c>/index',
                '<_c:[\w-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
                '<_c:[\w-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<action:reset-password>' => 'site/<action>',
            ],
        ],
    ],
    'params' => $params,
    'language' => 'ru-RU',
];
