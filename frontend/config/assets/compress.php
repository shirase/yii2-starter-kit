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
        'frontend\assets\FrontendAsset',
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
        'app' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'bundle/frontend.js',
            'css' => 'bundle/frontend.css',
            'depends' => [
                'frontend\assets\FrontendAsset',
            ],
        ],
    ],

    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets'
    ],
];