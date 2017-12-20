<?php
/**
 * Application configuration for backend functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/base.php'),
    require(YII_APP_BASE_PATH . '/common/config/web.php'),
    require(YII_APP_BASE_PATH . '/backend/config/base.php'),
    require(YII_APP_BASE_PATH . '/backend/config/web.php'),
    require(dirname(__DIR__) . '/base.php'),
    require(dirname(__DIR__) . '/web.php'),
    require(dirname(__DIR__) . '/functional.php'),
    [
        'components' => [
            'assetManager' => [
                'basePath' => YII_APP_BASE_PATH . '/backend/web/assets'
            ],
        ],
    ]
);