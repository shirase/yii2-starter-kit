<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
return [
    'id' => 'storage',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'glide/index',
    'controllerMap' => [
        'glide' => '\shirase55\glide\controllers\GlideController'
    ],
    'components' => [
        'urlManager'=>require(__DIR__.'/_urlManager.php'),
        'glide' => [
            'class' => 'shirase55\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/web/cache',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY'),
            'defaults' => [
                'q' => 80,
            ],
        ],
        'request' => [
            'baseUrl' => rtrim(env('STORAGE_URL'), '/'),
        ],
    ]
];
