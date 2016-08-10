<?php
namespace common\plugins\page_type\article;

use common\components\helpers\Url;
use common\models\PageType;
use common\plugins\page_type\PluginInterface;
use yii\helpers\ArrayHelper;

class Plugin implements PluginInterface {

    public static function getId() {
        return PageType::find()->andFilterWhere(['plugin'=>get_called_class()])->one()->id;
    }

    public static function dataModel($pageId) {
        return null;

        /*$model = Model::findOne($pageId);
        if (!$model) {
            $model = new Model();
            $model->id = $pageId;
        }
        return $model;*/
    }

    public static function widget($form, $model, $options=[]) {
        $options = ArrayHelper::merge(['form'=>$form, 'model'=>$model], $options);
        $widget = Widget::className();
        return $widget::widget($options);
    }

    public static function URI($Page) {
        $urlManager = \Yii::$app->urlManagerFrontend;

        if (isset($Page->slug)) {
            return $urlManager->createAbsoluteUrl(['/article/index', 'slug'=>$Page->slug]);
        } else {
            return $urlManager->createAbsoluteUrl(['/article/index', 'id'=>$Page->id]);
        }
    }
} 