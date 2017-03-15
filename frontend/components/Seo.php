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

        if($model->hasAttribute('page_title') && $model->page_title) {
            $view->title = $model->page_title;
        }
        elseif($model->hasAttribute('title') && $model->title) {
            $view->title = $model->title;
        }
        elseif($model->hasAttribute('name') && $model->name) {
            $view->title = $model->name;
        }

        if($model->hasAttribute('page_description') && $model->page_description) {
            $view->registerMetaTag(['name' => 'description', 'content'=>$model->page_description], 'description');
        }
        elseif($model->hasAttribute('body') && $model->body) {
            $view->registerMetaTag(['name' => 'description', 'content'=>StringHelper::truncateWords(strip_tags($model->body), 10, '')], 'description');
        }
        elseif($model->hasAttribute('text') && $model->text) {
            $view->registerMetaTag(['name' => 'description', 'content'=>StringHelper::truncateWords(strip_tags($model->text), 10, '')], 'description');
        }

        if($model->hasAttribute('page_keywords') && $model->page_keywords) {
            $view->registerMetaTag(['name' => 'keywords', 'content'=>$model->page_keywords], 'keywords');
        }
    }
}