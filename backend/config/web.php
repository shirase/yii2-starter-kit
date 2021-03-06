<?php
$config = [
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'timeline-event/index',
    'controllerMap' => [
        'file-manager-elfinder' => [
            'class' => mihaildev\elfinder\Controller::class,
            'access' => ['manager'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@storageUrl',
                    'basePath' => '@storage',
                    'path' => '/',
                    'access' => ['read' => 'manager', 'write' => 'manager']
                ]
            ]
        ]
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'baseUrl' => rtrim(env('BACKEND_URL'), '/'),
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'csrfParam' => '_backendCSRF',
        ],
        'user' => [
            'loginUrl'=>['sign-in/login'],
            'enableAutoLogin' => true,
        ],
    ],
    'bootstrap' => [
        'roles',
    ],
    'modules'=>[
        'i18n' => [
            'class' => backend\modules\i18n\Module::class,
            'defaultRoute' => 'i18n-message/index'
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'roles' => [
            'class' => 'mdm\admin\Module',
            'mainLayout' => '@backend/views/layouts/main.php',
            'layout' => 'left-menu',
            'menus' => [
                'user' => null,
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/ping',
        ]
    ],
    /*'as globalAccess'=>[
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['login']
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions' => ['logout']
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['error']
            ],
            [
                'controllers' => ['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers' => ['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers' => ['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager'],
            ]
        ]
    ],*/
    'as saverestore'=>[
        'class'=>'\shirase\returned\SaveRestoreBehavior'
    ],
];

if (YII_ENV_PROD) {
    // Compressed assets
    /*$config['components']['assetManager'] = [
       'bundles' => require(__DIR__ . '/assets/_bundles.php')
    ];*/
}

return $config;
