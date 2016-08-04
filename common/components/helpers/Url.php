<?php

namespace common\components\helpers;

use common\models\Page;

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
        $plugin = $model->plugin;
        $url = $plugin::URI($model);

        $urlManager = \Yii::$app->urlManagerFrontend;

        if (strpos($url, '://') === false) {
            $url = $urlManager->getHostInfo() . $url;
        }

        return $url;
    }

    public static function image($path, $params = [])
    {
        $params['path'] = $path;
        return \Yii::$app->glide->createSignedUrl($params);
    }
} 