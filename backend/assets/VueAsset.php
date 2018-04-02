<?php

namespace backend\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'bundle/vue-bundle.js',
    ];
}