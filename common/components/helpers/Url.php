<?php

namespace common\components\helpers;

class Url extends \yii\helpers\Url {

    public static function normalizeRoute($route) {
        return parent::normalizeRoute($route);
    }

    /**
     * @param \common\components\db\ActiveRecord $model
     * @return array
     */
    public static function routeFor($model) {
        if (isset($model->slug)) {
            $m = explode('\\', $model->className());
            return ['/'.strtolower(array_pop($m)).'/view', 'slug'=>$model->slug];
        } else {
            $m = explode('\\', $model->className());
            return ['/'.strtolower(array_pop($m)).'/view', 'id'=>$model->id];
        }
    }

    public static function image($path, $params=[]) {
        $params['path'] = $path;
        return \Yii::$app->glide->createSignedUrl($params);
    }
} 