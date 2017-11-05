<?php
namespace frontend\widgets;

use common\components\WidgetBuilder;

/**
 * Class InlineEditorBuilder
 * @static InlineEditorBuilder build($model, $attribute)
 * @method InlineEditorBuilder setContent($value)
 * @method InlineEditorBuilder setSaveUrl($value)
 * @method InlineEditorBuilder setId($value)
 */
class InlineEditorBuilder extends WidgetBuilder
{
    protected $class = InlineEditor::class;

    public static function build($model, $attribute) {
        $builder = new self();
        $builder->setData([
            'model' => $model,
            'attribute' => $attribute,
        ]);
        return $builder;
    }
}