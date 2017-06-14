<?php
namespace common\components;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        if (is_dir(\Yii::getAlias('@vendor/bower-asset')))
            \Yii::setAlias('@bower', '@vendor/bower-asset');

        if (is_dir(\Yii::getAlias('@vendor/npm-asset')))
            \Yii::setAlias('@npm', '@vendor/npm-asset');
    }
}