<?php

namespace common\web;

/**
 * Class Controller
 * @package common\web
 */
class Controller extends \yii\web\Controller
{
    public function render($view, $params = []) {
        if (\Yii::$app->request->isAjax) {
            return parent::renderAjax($view, $params);
        } else {
            return parent::render($view, $params);
        }
    }
}