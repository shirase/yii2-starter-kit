<?php
namespace common\plugins\page_type\link;

use common\plugins\page_type\PluginInterface;
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
        /** @var Widget $widget */
        $widget = Widget::className();
        return $widget::widget($options);
    }

    public static function URI($Page) {
        $dataModel = $Page->dataModel;
        if (!$dataModel) return false;

        return $dataModel->link;
    }

    public static function route($Page) {
        return 'page/view';
    }
} 