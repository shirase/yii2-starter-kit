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
        if (\Yii::$app->request->isPjax) {
            return null;
        }

        $view = \Yii::$app->controller->view;

        $seo = new \common\models\Seo();
        $seoKey = \yii\helpers\ArrayHelper::getValue($view->params, 'seoKey');
        if ($seoKey) {
            if ($s = \common\models\Seo::findOne($seoKey)) {
                $seo = $s;
            }
        }

        if (!$seo->title) {
            if($model->hasAttribute('title') && $model->title) {
                $seo->title = $model->title;
            }
            elseif($model->hasAttribute('name') && $model->name) {
                $seo->title = $model->name;
            }
        }

        if (!$seo->page_title) {
            if($model->hasAttribute('page_title') && $model->page_title) {
                $seo->page_title = $model->page_title;
            }
        }

        if($model->hasAttribute('page_description') && $model->page_description) {
            $seo->page_description = $model->page_description;
        }
        elseif($model->hasAttribute('body') && $model->body) {
            $seo->page_description = StringHelper::truncateWords(strip_tags($model->body), 10, '');
        }
        elseif($model->hasAttribute('text') && $model->text) {
            $seo->page_description = StringHelper::truncateWords(strip_tags($model->text), 10, '');
        }

        if($model->hasAttribute('page_keywords') && $model->page_keywords) {
            $seo->page_keywords = $model->page_keywords;
        }

        if($seo->title) {
            $view->title = $seo->title;
        }
        if($seo->page_title) {
            $view->params['page_title'] = $seo->page_title;
        }
        if($seo->page_description) {
            $view->registerMetaTag(['name' => 'description', 'content'=>$seo->page_description], 'description');
        }
        if($seo->page_keywords) {
            $view->registerMetaTag(['name' => 'keywords', 'content'=>$seo->page_keywords], 'keywords');
        }
    }
}