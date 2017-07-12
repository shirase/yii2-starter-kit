<?php
namespace common\plugins\page_type\content;

use common\models\Page;
use common\plugins\page_type\PageTypePlugin;
use yii\helpers\ArrayHelper;

class Plugin implements PageTypePlugin
{
    /**
     * @param null|Page $page
     * @return Model|null
     */
    public static function model($page = null) {
        $model = null;
        if ($page) {
            $model = Model::findOne($page->id);
        }
        if (!$model) {
            $model = new Model();
            $model->id = $page ? $page->id : 0;
        }
        return $model;
    }

    /**
     * @param Model $model
     * @param Page $page
     */
    public static function link($model, $page) {
        $model->id = $page->id;
    }

    public static function widget($form, $model, $options=[]) {
        $options = ArrayHelper::merge(['form'=>$form, 'model'=>self::model($model)], $options);
        /** @var Widget $widget */
        $widget = Widget::className();
        return $widget::widget($options);
    }

    public static function URI($page) {
        $urlManager = \Yii::$app->urlManagerFrontend;
        if (isset($page->slug)) {
            return $urlManager->createAbsoluteUrl(['/page/view', 'slug'=>$page->slug]);
        } else {
            return $urlManager->createAbsoluteUrl(['/page/view', 'id'=>$page->id]);
        }
    }

    public static function route($page) {
        return 'page/view';
    }
} 