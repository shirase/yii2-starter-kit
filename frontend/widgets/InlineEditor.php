<?php
namespace frontend\widgets;

use dosamigos\ckeditor\CKEditorInline;
use frontend\assets\CKEditorAsset;
use frontend\assets\EditableAsset;
use yii\base\Widget;
use yii\helpers\Html;

class InlineEditor extends Widget
{
    public $saveUrl;
    public $model;
    public $attribute;

    public function init() {
        if ($this->model) {
            $this->saveUrl = \Yii::$app->urlManager->createUrl([preg_replace('/([A-Z])/', '-$1', strtolower(array_pop(explode('\\', get_class($this->model))))) . '/update', 'id'=>$this->model->primaryKey]);
            if ($this->attribute) {
                $this->attribute = $this->model->formName() . '[' . $this->attribute . ']';
            }
        }

        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        echo '<div class="inline_content">';
        if (\Yii::$app->user->can('administrator')) {
            EditableAsset::register($this->view);

            $path = \Yii::getAlias('@frontend').'/web/ckeditor_plugins';
            $url = \Yii::getAlias('@frontendUrl').'/ckeditor_plugins';
            $this->view->registerJs("CKEDITOR.plugins.addExternal('inlinesave', '".$url."/inlinesave/plugin.js?v=".filemtime($path.'/inlinesave/plugin.js')."', '');");

            CKEditorInline::begin([
                'options' => [
                    'data-saveurl'=>$this->saveUrl,
                    'data-attribute'=>$this->attribute,
                ],
                'preset' => 'custom',
                'clientOptions' => [
                    'extraPlugins' => 'inlinesave',
                    'toolbar' => [
                        ['InlineSave', 'Sourcedialog'],
                        ['Undo', 'Redo'],
                        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteCode'],
                        ['Bold', 'Italic'],
                        ['NumberedList', 'BulletedList', 'Outdent', 'Indent'],
                        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                        ['Link', 'Unlink'],
                        ['FontSize', 'Styles', 'Format'],
                        ['Table'],
                        ['RemoveFormat'],
                    ]
                ],
            ]);
            echo $content;
            CKEditorInline::end();
        } else {
            echo Html::tag('div', $content);
        }
        echo '</div>';
    }
}