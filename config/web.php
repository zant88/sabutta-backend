<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'sabutta',
    'timeZone' => 'Asia/Jakarta',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aNpSGZ_RkJ8HwH8rxjoOYpZ-F4-X2SJg',
        ],
        // 'assetManager' => [
        //     'bundles' => [
        //         'kartik\form\ActiveFormAsset' => [
        //             'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
        //         ],
        //     ],
        // ],
        // 'user' => [
        //     'class' => 'amnah\yii2\user\components\User',
        // ],
        'user' => [
            'class' => 'app\modules\user\components\User',
            'identityClass' => 'app\modules\user\models\User',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'errorHandler' => [
        //     'errorAction' => 'site/error',
        // ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        // 'user' => [
        //     'class' => 'amnah\yii2\user\Module',
        //     // set custom module properties here ...
        // ],
        'user' => [
            'class' => 'app\modules\user\Module',
            'controllerMap' => [
                // 'default' => 'app\controllers\MyDefaultController',
                'default' => 'app\modules\user\controllers\DefaultController',
            ],
            'modelClasses'  => [
                'User' => 'app\modules\user\models\User', // note: don't forget component user::identityClass above
                'Profile' => 'app\modules\user\models\Profile',
            ],
            'emailViewPath' => '@app/modules/user/mail',
            // set custom module properties here ...
        ],
        'utility' => [
            'class' => 'c006\utility\migration\Module',
        ],
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
            // other module settings
        ],
        'gallery4' => [
            'class' => 'zantknight\yii\gallery\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     'allowedIPs' => ['*'],
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
        'generators' => [
            'myCrud' => [
                'class' => 'app\templates\crud\Generator',
                'templates' => [
                    'my' => '@app/Templates/crud/default',
                ]
            ],

        ],
    ];
}

return $config;
