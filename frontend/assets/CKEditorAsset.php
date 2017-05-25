<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/ckeditor';

    public $js = [
        'dialog.js',
    ];
}