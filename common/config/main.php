<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads'   => '@frontend/web/uploads',
    ],
    'name' => 'sobor',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'ru-RU',
//            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/rbac/items/items.php',
            'assignmentFile' => '@common/rbac/items/assignments.php',
            'ruleFile' => '@common/rbac/items/rules.php',
            'defaultRoles' => ['user'],
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['manager'],
            'root' => [
                'baseUrl'=> 'http://' . $_SERVER['HTTP_HOST'] . '/uploads',
                'basePath'=>'@uploads',
                'path' => 'files',
                'name' => 'Файлы для редактора'
            ],
        ]
    ],
];
