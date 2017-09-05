<?php
namespace common\components;

use yii\base\BootstrapInterface;
use yii\data\Pagination;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        \Yii::$container->set(Pagination::class, [
            'forcePageParam' => false,
        ]);
    }
}