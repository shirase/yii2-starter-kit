<?php
namespace common\plugins\page_type\article;

use common\models\Page;
use common\plugins\page_type\PageTypePlugin;
use yii\helpers\ArrayHelper;

class Plugin implements PageTypePlugin
{
    const PAGE_TYPE_ID = 4;

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
            return $urlManager->createAbsoluteUrl(['/article/index', 'slug'=>$page->slug]);
        } else {
            return $urlManager->createAbsoluteUrl(['/article/index', 'id'=>$page->id]);
        }
    }

    public static function route($page) {
        return 'article/index';
    }
} 