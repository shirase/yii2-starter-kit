<?php
/**
 * This file is generated by the "yii asset" command.
 * DO NOT MODIFY THIS FILE DIRECTLY.
 * @version 2017-09-27 10:59:02
 */
return [
    'vendor' => [
        'class' => 'yii\\web\\AssetBundle',
        'basePath' => '@webroot',
        'baseUrl' => '@web',
        'js' => [
            'bundle/vendor.js',
        ],
        'css' => [],
        'depends' => [],
        'sourcePath' => null,
    ],
    'yii\\web\\JqueryAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'vendor',
        ],
    ],
    'yii\\web\\YiiAsset' => [
        'sourcePath' => null,
        'js' => [],
        'css' => [],
        'depends' => [
            'yii\\web\\JqueryAsset',
            'vendor',
        ],
    ],
];