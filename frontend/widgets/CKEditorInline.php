<?php

namespace frontend\widgets;

use dosamigos\ckeditor\CKEditorAsset;
use yii\helpers\Json;
use yii\web\View;

class CKEditorInline extends \dosamigos\ckeditor\CKEditorInline
{
    protected function initOptions()
    {
        parent::initOptions();
        $this->options['contenteditable'] = 'false';
    }

    protected function registerPlugin()
    {
        $js = [];

        $view = $this->getView();

        CKEditorAsset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        if ($this->disableAutoInline) {
            $view->registerJs('CKEDITOR.disableAutoInline = true;', View::POS_END);
        }

        $js[] = <<<JS
(function($) {
    var tapTimer;
    var isActive = false;
    $('#$id')
        .mousedown(function(event) {
            var el = $(this);
            tapTimer = setTimeout(function() {
                console.log(1);
                if (isActive) {
                    el.off('mousedown');
                    return;
                }

                isActive = true;
                    el.prop('contenteditable', true);
                    CKEDITOR.inline('$id', $options);
            }, 500);
        })
        .mouseup(function() {
            var el = $(this);
            if (isActive) {
                el.off('mouseup');
                return;
            }
            clearTimeout(tapTimer);
        });
})(jQuery);
JS;

        if (isset($this->clientOptions['filebrowserUploadUrl'])) {
            $js[] = "dosamigos.ckEditorWidget.registerCsrfImageUploadHandler();";
        }

        $view->registerJs(implode("\n", $js));
    }
}