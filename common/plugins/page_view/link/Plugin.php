<?php
namespace common\plugins\page_view\link;

class Plugin {

    public static function dataModel($pageId) {
        $model = Model::findOne($pageId);
        if (!$model) {
            $model = new Model();
            $model->id = $pageId;
        }
        return $model;
    }

    public static function widget($options=[]) {
        $widget = Widget::className();
        return $widget::widget($options);
    }
} 