<?php
/**
 * Require core files
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * Setting path aliases
 */
Yii::setAlias('@base', realpath(__DIR__.'/../../'));
Yii::setAlias('@common', realpath(__DIR__.'/../../common'));
Yii::setAlias('@frontend', realpath(__DIR__.'/../../frontend'));
Yii::setAlias('@backend', realpath(__DIR__.'/../../backend'));
Yii::setAlias('@console', realpath(__DIR__.'/../../console'));
Yii::setAlias('@storage', realpath(__DIR__.'/../../storage'));
Yii::setAlias('@tests', realpath(__DIR__.'/../../tests'));
Yii::setAlias('@api', realpath(__DIR__.'/../../api'));

Yii::setAlias('@frontendWeb', '@frontend/web');
Yii::setAlias('@backendWeb', '@backend/web');
Yii::setAlias('@storageWeb', '@storage/web');

/**
 * Setting url aliases
 */
Yii::setAlias('@frontendUrl', env('FRONTEND_HOST') . env('FRONTEND_URL'));
Yii::setAlias('@backendUrl', env('BACKEND_HOST') . env('BACKEND_URL'));
Yii::setAlias('@storageUrl', env('STORAGE_HOST') . env('STORAGE_URL'));
Yii::setAlias('@apiUrl', env('API_HOST') . env('API_URL'));

Swift_DependencyContainer::getInstance()
    ->register('mime.qpcontentencoder')
    ->asAliasOf('mime.base64contentencoder');

define('DATE_SQL', 'Y-m-d H:i:s');
