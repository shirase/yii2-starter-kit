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
            'maxImageSize' => getenv('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => getenv('GLIDE_SIGN_KEY') === 'false' ? false : getenv('GLIDE_SIGN_KEY')
        ]
    ]
];
