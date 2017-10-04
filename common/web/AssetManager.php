<?php
namespace common\web;

class AssetManager extends \yii\web\AssetManager
{
    protected function publishDirectory($src, $options) {
        $cwd = getcwd();
        $prefix = \Yii::getAlias('@base');
        chdir($prefix);
        if ($prefix === substr($src, 0, strlen($prefix))) {
            $src = substr($src, strlen($prefix)+1);
        }
        $ret = parent::publishDirectory($src, $options);
        chdir($cwd);
        return $ret;
    }
}