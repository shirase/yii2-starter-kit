<?php

namespace common\assets;

use yii\web\AssetBundle;

class JqueryMigrateAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-migrate';
    public $js = [
        'jquery-migrate.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}