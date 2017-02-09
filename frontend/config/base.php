<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__.'/_urlManager.php'),
        'cache' => require(__DIR__.'/_cache.php'),
    ],
    /*'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
    ],*/
];
