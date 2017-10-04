<?php
namespace common\components\helpers;

class AssetHelper
{
    public static function hashCallback($path)
    {
        $prefix = \Yii::getAlias('@base');
        if ($prefix === substr($path, 0, strlen($prefix))) {
            $path = substr($path, strlen($prefix)+1);
        }
        return sprintf('%x', crc32(str_replace('\\', '/', $path) . \Yii::getVersion()));
    }
}