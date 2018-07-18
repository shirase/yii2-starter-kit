<?php
require_once( __DIR__ . '/../../bootstrap.php');

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'test');

// Prepare Yii
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/common/config/bootstrap.php');

$config = require(__DIR__ . '/../config/common/unit.php');
new yii\web\Application($config);

Yii::setAlias('@tests', dirname(dirname(__DIR__)));