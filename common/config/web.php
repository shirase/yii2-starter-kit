<?php
$config = [
    'modules' => [
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'php:d.m.Y',
                \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:d.m.Y H:i:s',
            ],

            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d',
                \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            //'displayTimezone' => 'Europe/Moscow',

            // set your timezone for date saved to db
            //'saveTimezone' => 'UTC',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion' => false,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => ['pluginOptions'=>['autoclose'=>true]],
                \kartik\datecontrol\Module::FORMAT_DATETIME => ['pluginOptions'=>['autoclose'=>true]],
                \kartik\datecontrol\Module::FORMAT_TIME => ['pluginOptions'=>['autoclose'=>true]],
            ],
        ],
    ],
    'components' => [
        'assetManager' => [
            'class' => \yii\web\AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => true,
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'scss' => ['css',
                        'npm run --prefix "'.Yii::getAlias('@base').'" sass -- --in {from}'],
                ],
            ],
            'hashCallback' => function($path) {
                $prefix = \Yii::getAlias('@base');
                if ($prefix === substr($path, 0, strlen($prefix))) {
                    $path = substr($path, strlen($prefix)+1);
                }
                return sprintf('%x', crc32(str_replace($path, '\\', '/') . Yii::getVersion()));
            },
        ],
        'user' => [
            'class' => 'common\web\User',
            'identityClass' => 'common\models\User',
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],
    ],
    /*'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => false
    ]*/
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'migrik'=>[
                'class'=>\insolita\migrik\gii\StructureGenerator::class,
                'templates'=>
                    [
                        'custom'=>'@backend/gii/templates/migrator_schema'
                    ]
            ],
            'migrikdata'=>[
                'class'=>\insolita\migrik\gii\DataGenerator::class,
                'templates'=>
                    [
                        'custom'=>'@backend/gii/templates/migrator_data'
                    ]
            ],
            'fixture' => [
                'class' => 'elisdn\gii\fixture\Generator',
            ],
            'job' => [
                'class' => \yii\queue\gii\Generator::class,
            ],
        ],
    ];
}


return $config;
