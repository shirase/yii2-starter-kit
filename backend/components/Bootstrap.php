<?php
namespace backend\components;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        \Yii::$container->set(
            'yii\imperavi\Widget',
            function ($container, $params, $config) {
                return new \yii\imperavi\Widget(
                    \yii\helpers\ArrayHelper::merge(
                        [
                            'plugins' => ['fullscreen'],
                            'options' => [
                                'minHeight' => 200,
                                'convertDivs' => false,
                                'removeEmptyTags' => false,
                                'imageUpload' => \Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
                            ],
                        ],
                        $config
                    )
                );
            }
        );

        \Yii::$container->set(
            'shirase55\filekit\widget\Upload',
            function ($container, $params, $config) {
                return new \shirase55\filekit\widget\Upload(
                    \yii\helpers\ArrayHelper::merge(
                        [
                            'url' => ['/file-storage/upload'],
                            'maxFileSize' => 10000000,
                        ],
                        $config
                    )
                );
            }
        );
    }
}