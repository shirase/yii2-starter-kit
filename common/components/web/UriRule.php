<?php
namespace common\components\web;

use common\models\Uri;
use yii\helpers\ArrayHelper;
use yii\web\UrlRule;

class UriRule extends UrlRule
{
    public $pattern = '<slug>';
    public $externalParams = [];
    public $targetRoute;

    public function parseRequest($manager, $request)
    {
        $Uri = Uri::find()
            ->orderBy('id DESC')
            ->andWhere(['uri'=>'/'.$request->pathInfo])
            ->one();

        if ($Uri) {
            if ($Uri->redirect_id) {
                $U = $Uri;
                while ($U->redirect_id) {
                    $U = Uri::findOne($U->redirect_id);
                }
                header('Location: '.$U->uri);
                exit;
            }

            if ($Uri->canonical_id) {
                $U = $Uri;
                while ($U->canonical_id) {
                    $U = Uri::findOne($U->canonical_id);
                }
                \Yii::$app->view->registerLinkTag(['rel'=>'canonical', 'href'=>$U->uri]);
            }

            list($route, $params1) = explode('?', $Uri->route);
            $params = [];
            parse_str($params1, $params);

            if ($this->targetRoute !== null && $this->targetRoute !== $route) {
                return false;
            }

            return [$route, $params];
        }

        return false;
    }

    public function createUrl($manager, $route, $params) {
        if ($this->mode === self::PARSING_ONLY) {
            return false;
        }

        if ($this->targetRoute !== null && $this->targetRoute !== $route) {
            return false;
        }

        $externalParams = [];
        foreach ($this->externalParams as $paramName) {
            if (array_key_exists($paramName, $params)) {
                $externalParams[$paramName] = $params[$paramName];
                unset($params[$paramName]);
            }
        }

        ksort($params);

        $Uri = Uri::find()
            ->andWhere('redirect_id IS NULL')
            ->orderBy('id DESC')
            ->andWhere(['route'=>$route . '?' . http_build_query($params)])
            ->one();

        if ($Uri) {
            return ltrim($Uri->uri, '/') . ($externalParams ? ('?' . http_build_query($externalParams)) : '');
        }

        return false;
    }
}