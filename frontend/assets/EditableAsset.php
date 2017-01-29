<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class EditableAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/editable';

    public $css = [
        'editable.css',
    ];
}