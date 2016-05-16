<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        ['pattern'=>'cache/<params>/<path:(.*)>', 'route'=>'glide/index', 'encodeParams' => false],
        ['pattern'=>'cache/<path:(.*)>', 'route'=>'glide/index', 'encodeParams' => false],
    ]
];
