<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require __DIR__.'/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],
    'bootstrap'=>[
        'backend\components\Bootstrap'
    ],
    /*'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
    ],*/
];
