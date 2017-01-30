<?php
namespace frontend\components;

use common\components\helpers\Url;
use yii\db\ActiveRecord;

class Breadcrumbs
{
    /**
     * @param ActiveRecord $model
     */
    public static function make($model, $lastName=null) {
        $view = \Yii::$app->controller->view;

        $class = $model->className();
        if ($path = $model->getPath()) {
            $view->params['breadcrumbs'] = [];
            foreach ($path as $id) {
                $one = $class::findOne($id);
                if (!$one->pid)
                    continue;
                $view->params['breadcrumbs'][] = ['label' => isset($one->name) ? $one->name : (isset($one->title) ? $one->title : ''), 'url' => Url::pageUrl($one)];
            }

            if ($lastName) {
                $view->params['breadcrumbs'][] = $lastName;
            } else {
                $last = array_pop($view->params['breadcrumbs']);
                $view->params['breadcrumbs'][] = $last['label'];
            }
        }
    }
}