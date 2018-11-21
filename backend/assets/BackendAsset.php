<?php
namespace backend\assets;

use common\assets\AdminLte;
use common\assets\Html5shiv;
use common\assets\JqueryMigrateAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/app.js'
    ];

    public $depends = [
        YiiAsset::class,
        AdminLte::class,
        JqueryMigrateAsset::class,
    ];
}
