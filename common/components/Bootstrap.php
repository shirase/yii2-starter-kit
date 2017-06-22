<?php
namespace common\components;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        \Yii::setAlias('@bower', '@vendor/bower-asset');
        \Yii::setAlias('@npm', '@vendor/npm-asset');
    }
}