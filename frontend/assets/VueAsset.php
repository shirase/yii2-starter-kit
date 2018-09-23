<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class VueAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'bundle/vue-bundle.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}