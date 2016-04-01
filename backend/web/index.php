<?php
// Composer
require(__DIR__ . '/../../vendor/autoload.php');

// Environment
require(__DIR__ . '/../../common/env.php');

// Yii
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/base.php'),
    require(__DIR__ . '/../../common/config/web.php'),
    require(__DIR__ . '/../config/base.php'),
    require(__DIR__ . '/../config/web.php')
);

$app = new yii\web\Application($config);

\Yii::$container->set('yii\imperavi\Widget', function ($container, $params, $config) {
    return new yii\imperavi\Widget(
        \yii\helpers\ArrayHelper::merge(
            [
                'plugins' => ['fullscreen'],
                'options' => [
                    'minHeight' => 200,
                    'convertDivs' => false,
                    'removeEmptyTags' => false,
                    'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
                ],
            ],
            $config
        )
    );
});

$app->run();