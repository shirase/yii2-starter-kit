<?php

namespace common\web;

use yii\db\ActiveRecord;
use yii\web\UrlRule;

class SlugUrlRule extends UrlRule
{
    /**
     * @var ActiveRecord
     */
    public $modelClass;

    public function parseRequest($manager, $request)
    {
        $route_params = parent::parseRequest($manager, $request);

        if (is_array($route_params) && isset($route_params[1])) {
            $params = $route_params[1];
            if (isset($params['slug'])) {
                $model = $this->modelClass::findOne(['slug' => $params['slug']]);
                if (!$model) {
                    return false;
                }
            }
        }

        return $route_params;
    }
}
