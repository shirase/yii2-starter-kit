<?php

namespace common\components\web;

/**
 * Class Controller
 * @package common\components\web
 */
class Controller extends \yii\web\Controller
{
    public function render($view, $params = []) {
        if (\Yii::$app->request->isAjax) {
            parent::renderAjax($view, $params);
        } else {
            parent::render($view, $params);
        }
    }
}