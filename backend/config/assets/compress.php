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
    'cssCompressor' => 'npm run --prefix "'.\Yii::getAlias('@base').'" css -- --in {from} --out {to}',

    // The list of asset bundles to compress:
    'bundles' => [
        'common\assets\AdminLte',
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\grid\GridViewAsset',
        'yii\widgets\PjaxAsset',
        'kartik\form\ActiveFormAsset',
        'kartik\grid\GridViewAsset',
        'kartik\dialog\DialogBootstrapAsset',
        'kartik\grid\GridExportAsset',
        'kartik\grid\GridResizeColumnsAsset',
        'kartik\base\WidgetAsset',
        'kartik\select2\Select2Asset',
        'kartik\select2\ThemeKrajeeAsset',
        'shirase\grid\sortable\SortableAsset',
    ],

    // Asset bundle for compression output:
    'targets' => [
        'vendor' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'bundle/vendor.js',
            'css' => 'bundle/vendor.css',
            'depends' => [],
        ],
    ],

    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'linkAssets' => env('LINK_ASSETS'),
        'converter' => [
            'class' => 'yii\web\AssetConverter',
            'commands' => [
                'scss' => ['css',
                    'npm run --prefix "'.Yii::getAlias('@base').'" sass -- --in {from}'],
            ],
        ],
        'hashCallback' => function($path) {
            return \common\components\helpers\AssetHelper::hashCallback($path);
        },
    ],
];