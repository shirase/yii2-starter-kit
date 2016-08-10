<?php

namespace common\components\web\url;

use common\plugins\page_type\PluginInterface;
use yii\web\UrlRule;

class Page extends UrlRule
{
    public $pattern = '<slug>';

    public function parseRequest($manager, $request)
    {
        $res = parent::parseRequest($manager, $request);

        if ($res) {
            if (isset($res[1]['slug'])) {
                $slug = $res[1]['slug'];
            } else {
                return false;
            }

            if ($Page = \common\models\Page::find()->andWhere(['slug' => $slug])->one()) {
                /**
                 * @var PluginInterface $plugin
                 */
                if ($plugin = $Page->type->plugin) {
                    if ($res[0] === $plugin::route($Page)) {
                        return $res;
                    }
                } else {
                    if ($res[0] === 'page/view') {
                        return $res;
                    }
                }
            }
        }

        return false;
    }
}