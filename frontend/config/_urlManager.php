<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['class'=>'common\web\SeoUrlRule'],
        ['class'=>'common\web\UriRule', 'route'=>'page/view', 'externalParams' => ['page']],

        // Articles
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/index', 'route'=>'article/index'],
        ['pattern'=>'article/update', 'route'=>'article/update'],
        ['pattern'=>'article/view', 'route'=>'article/view'],

        ['pattern'=>'article/<slug>', 'route'=>'article/view'],

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']],

        ['pattern'=>'<controller>', 'route'=>'<controller>/index'],
        ['pattern'=>'<controller>/<action>', 'route'=>'<controller>/<action>'],
        ['pattern'=>'<module>/<controller>', 'route'=>'<module>/<controller>/index'],
    ]
];
