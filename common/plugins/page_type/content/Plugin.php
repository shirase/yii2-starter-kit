<?php
namespace common\plugins\page_type\content;

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
        $urlManager = \Yii::$app->urlManagerFrontend;
        if (isset($Page->slug)) {
            return $urlManager->createAbsoluteUrl(['/page/view', 'slug'=>$Page->slug]);
        } else {
            return $urlManager->createAbsoluteUrl(['/page/view', 'id'=>$Page->id]);
        }
    }

    public static function route($Page) {
        return 'page/view';
    }
} 