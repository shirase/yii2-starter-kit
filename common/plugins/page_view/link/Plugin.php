<?php
namespace common\plugins\page_view\link;

use common\plugins\page_view\PluginInterface;
use yii\helpers\ArrayHelper;

class Plugin implements PluginInterface {

    public static function dataModel($pageId) {
        $model = Model::findOne($pageId);
        if (!$model) {
            $model = new Model();
            $model->id = $pageId;
        }
        return $model;
    }

    public static function widget($form, $model, $options=[]) {
        $options = ArrayHelper::merge(['form'=>$form, 'model'=>$model], $options);
        $widget = Widget::className();
        return $widget::widget($options);
    }
} 