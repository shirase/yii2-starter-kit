<?php
namespace frontend\widgets;

use dosamigos\ckeditor\CKEditorInline;
use dosamigos\ckeditor\CKEditorWidgetAsset;
use frontend\assets\CKEditorAsset;
use frontend\assets\EditableAsset;
use iutbay\yii2kcfinder\KCFinderAsset;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class InlineEditor extends Widget
{
    public $saveUrl;

    /**
     * @var ActiveRecord
     */
    public $model;

    public $attribute;

    public $content;

    public function init() {
        if ($this->model) {
            $this->saveUrl = \Yii::$app->urlManager->createUrl([strtolower(preg_replace('/([A-Z])/', '-$1', lcfirst(array_pop(explode('\\', get_class($this->model)))))) . '/update', 'id'=>$this->model->primaryKey]);
            if ($this->attribute) {
                if ($this->content === null) {
                    $this->content = $this->model->{$this->attribute};
                }
                $this->attribute = $this->model->formName() . '[' . $this->attribute . ']';
            }
        }

        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        if ($this->content) {
            $content = $this->content;
        }
        echo '<div class="inline_content">';
        if (\Yii::$app->user->can('administrator')) {
            EditableAsset::register($this->view);

            $stylesSet = Json::encode([
                ['name'=>'Таблица с оформлением', 'element'=>'table', 'attributes'=> ['class'=>'table-decorated']],
            ]);
            $this->view->registerJs("CKEDITOR.stylesSet.add('default', {$stylesSet});");

            $path = \Yii::getAlias('@vendor/shirase55/ckeditor-inlinesave');
            $url = $this->view->assetManager->publish($path.'/dist')[1];
            $this->view->registerJs("CKEDITOR.plugins.addExternal('inlinesave', '".$url."/plugin.js?v=".filemtime($path.'/dist/plugin.js')."', '');");

            $path = \Yii::getAlias('@vendor/shirase55/ckeditor-image');
            $url = $this->view->assetManager->publish($path.'/dist')[1];
            $this->view->registerJs("CKEDITOR.plugins.addExternal('image-uf', '".$url."/plugin.js?v=".filemtime($path.'/dist/plugin.js')."', '');");

            $path = \Yii::getAlias('@frontend/web/ckeditor/widgets');
            $url = \Yii::getAlias('@frontendUrl/ckeditor/widgets');
            $this->view->registerJs("CKEDITOR.plugins.addExternal('widgets', '".$url."/plugin.js?v=".filemtime($path.'/plugin.js')."', '');");

            $this->view->registerJs('CKEDITOR.disableAutoInline = true;', View::POS_END);

            $kcfinderUrl = KCFinderAsset::register($this->view)->baseUrl;
            \Yii::$app->session->set('KCFINDER', [
                'uploadURL' => \Yii::getAlias('@frontendUrl') . '/data',
                'uploadDir' => \Yii::getAlias('@frontendWeb') . '/data',
                'disabled'=>false,
                'denyZipDownload' => true,
                'denyUpdateCheck' => true,
                'denyExtensionRename' => true,
                'theme' => 'default',
                'access' => [
                    'files' => [
                        'upload' => true,
                        'delete' => false,
                        'copy' => false,
                        'move' => false,
                        'rename' => false,
                    ],
                    'dirs' => [
                        'create' => true,
                        'delete' => false,
                        'rename' => false,
                    ],
                ],
                'imageDriversPriority' => 'gd',
                'types'=>[
                    'files' => [
                        'type' => '',
                    ],
                    'images' => [
                        'type' => '*img',
                    ],
                ],
                'thumbsDir' => '.thumbs',
                'thumbWidth' => 100,
                'thumbHeight' => 100,
            ]);

            CKEditorWidgetAsset::register($this->view);

            CKEditorInline::begin([
                'id' => $this->id,
                'options' => [
                    'data-saveurl'=>$this->saveUrl,
                    'data-attribute'=>$this->attribute,
                ],
                'preset' => 'custom',
                'clientOptions' => [
                    'extraAllowedContent' => 'iframe[*];script;style;blockquote;img[*]{*}(*);div[*]{*}(*);span[*]{*}(*);p[*]{*}(*);',
                    'extraPlugins' => 'justify,inlinesave,image-uf,widgets',
                    'removePlugins'=>'image',
                    'filebrowserBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=files',
                    'filebrowserUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=files',
                    'toolbar' => [
                        ['InlineSave', 'Sourcedialog'],
                        ['Undo', 'Redo'],
                        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteCode'],
                        ['Bold', 'Italic'],
                        ['NumberedList', 'BulletedList', 'Outdent', 'Indent'],
                        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                        ['Link', 'Unlink'],
                        ['FontSize', 'Styles', 'Format'],
                        ['Table', 'image-uf', 'Widgets'],
                        ['RemoveFormat'],
                    ]
                ],
            ]);
            echo $content;
            CKEditorInline::end();

            CKEditorAsset::register($this->view);
        } else {
            echo Html::tag('div', $content);
        }
        echo '</div>';
    }
}