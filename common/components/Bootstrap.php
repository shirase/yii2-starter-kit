<?php
namespace common\components;

use yii\base\BootstrapInterface;
use yii\data\Pagination;
use yii\web\JqueryAsset;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        \Yii::$container->set(Pagination::class, [
            'forcePageParam' => false,
        ]);

        \Yii::$container->set(JqueryAsset::class, [
            'js' => [
                'jquery.min.js',
            ]
        ]);
    }
}