<?php
/**
 * Configuration file for the "yii asset" console command.
 * @author Eugene Terentev <eugene@terentev.net>
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', Yii::getAlias('@frontend/web'));
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'uglifyjs {from} -o {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'npm run --prefix "'.\Yii::getAlias('@base').'" css -- --in {from} --out {to}',

    // The list of asset bundles to compress:
    'bundles' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
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
        'hashCallback' => function($path) {
            return \common\components\helpers\AssetHelper::hashCallback($path);
        },
    ],
];