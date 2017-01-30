<?php

namespace frontend\components;

use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

class Seo
{
    /**
     * @param $model ActiveRecord
     */
    public static function make($model) {
        $view = \Yii::$app->controller->view;

        if($model->hasAttribute('title') && $model->title) {
            $view->title = $model->title;
        }
        elseif($model->hasAttribute('name') && $model->name) {
            $view->title = $model->name;
        }

        if($model->hasAttribute('body') && $model->body) {
            $view->registerMetaTag(['name' => 'description', 'content'=>StringHelper::truncateWords(strip_tags($model->body), 10, '')], 'description');
        }
        elseif($model->hasAttribute('title') && $view->title) {
            $view->registerMetaTag(['name' => 'description', 'content'=>$view->title], 'description');
        }

        if($model->hasAttribute('title') && $view->title) {
            $view->registerMetaTag(['name' => 'keywords', 'content'=>$view->title], 'keywords');
        }
    }
}