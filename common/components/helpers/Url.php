<?php

namespace common\components\helpers;

use common\plugins\page_type\PageTypePlugin;

class Url extends \yii\helpers\Url
{
    public static function normalizeRoute($route)
    {
        return parent::normalizeRoute($route);
    }

    /**
     * @param \common\models\Page $model
     * @return string
     */
    public static function pageUrl($model)
    {
        $urlManager = \Yii::$app->urlManagerFrontend;

        if ($model->type && $plugin = $model->type->plugin) {
            /** @var PageTypePlugin $plugin */
            $url = $plugin::URI($model);
        } else {
            if (isset($model->slug)) {
                $url = $urlManager->createAbsoluteUrl(['/page/view', 'slug'=>$model->slug]);
            } else {
                $url = $urlManager->createAbsoluteUrl(['/page/view', 'id'=>$model->id]);
            }
        }

        return $url;
    }

    public static function image($path, $params = [])
    {
        $params['path'] = $path;
        return \Yii::$app->glide->createSignedUrl($params);
    }
} 