<?php
require_once( __DIR__ . '/../../bootstrap.php');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/common/config/bootstrap.php');
require_once(YII_APP_BASE_PATH . '/backend/config/bootstrap.php');

Yii::setAlias('@tests', dirname(dirname(__DIR__)));
