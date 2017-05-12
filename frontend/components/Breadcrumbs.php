<?php
namespace frontend\components;

use common\components\helpers\Url;
use common\models\Page;
use yii\helpers\ArrayHelper;

class Breadcrumbs
{
    /**
     * @param Page $model
     * @param null $lastName
     */
    public static function make($model, $lastName=null) {
        $view = \Yii::$app->controller->view;

        /** @var Page $class */
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

    private static $activeUrls;

    public static function getActiveUrls($reload = false) {
        if (self::$activeUrls && !$reload) {
            return self::$activeUrls;
        }

        self::$activeUrls = [
            rtrim(\Yii::$app->request->baseUrl, '/') . '/' . \Yii::$app->request->pathInfo
        ];

        $view = \Yii::$app->controller->view;
        if ($breadcrumbs = ArrayHelper::getValue($view->params, 'breadcrumbs')) {
            foreach ($breadcrumbs as $row) {
                if ($url = ArrayHelper::getValue($row, 'url')) {
                    self::$activeUrls[] = $url;
                }
            }
        }

        return self::$activeUrls;
    }

    /**
     * @param string $url
     */
    public static function checkActive($url) {
        $activeUrls = self::getActiveUrls();
        return array_search($url, $activeUrls) !== false;
    }
}