<?php
/**
 * Configuration file for the "yii asset" console command.
 * @author Eugene Terentev <eugene@terentev.net>
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', Yii::getAlias('@backend/web'));
Yii::setAlias('@web', '/admin');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'uglifyjs {from} -o {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'yuicompressor --type css {from} -o {to}',

    // The list of asset bundles to compress:
    'bundles' => [
        'backend\assets\BackendAsset',
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'common\assets\AdminLte',
        'kartik\form\ActiveFormAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'shirase\grid\sortable\SerialColumnAsset',
        'kartik\grid\GridViewAsset',
        'kartik\dialog\DialogBootstrapAsset',
        'kartik\dialog\DialogAsset',
        'kartik\grid\GridExportAsset',
        'kartik\grid\GridResizeColumnsAsset',
        'yii\grid\GridViewAsset',
        'yii\widgets\PjaxAsset',
    ],

    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'bundle/{hash}.js',
            'css' => 'bundle/{hash}.css',
        ],
    ],

    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets'
    ],
];