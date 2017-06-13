<?php
namespace backend\components;

use yii\base\BootstrapInterface;
use yii\web\View;

class Bootstrap extends \common\components\Bootstrap
{
    public function bootstrap($app)
    {
        parent::bootstrap($app);

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
                                'replaceDivs' => false,
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

        \Yii::$container->set('kartik\dialog\DialogAsset', [
            'jsOptions' => [
                'position' => View::POS_END
            ]
        ]);

        \Yii::$container->set('kartik\dialog\Dialog', [
            'jsPosition' => View::POS_END,
        ]);

        \Yii::$container->set('kartik\grid\GridView', [
            'export' => false,
        ]);
    }
}