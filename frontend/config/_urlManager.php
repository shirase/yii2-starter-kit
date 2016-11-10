<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['class'=>'common\components\web\url\Page', 'route'=>'page/view'],

        // Articles
        ['class'=>'common\components\web\url\Page', 'route'=>'article/index'],
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/<slug>', 'route'=>'article/view'],

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']],

        ['pattern'=>'<controller>', 'route'=>'<controller>/index'],
        ['pattern'=>'<controller>/<action>', 'route'=>'<controller>/<action>'],
        ['pattern'=>'<module>/<controller>', 'route'=>'<module>/<controller>/index'],
    ]
];
