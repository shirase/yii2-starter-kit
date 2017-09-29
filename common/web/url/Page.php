<?php

namespace common\web\url;

use common\plugins\page_type\PageTypePlugin;
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

            if ($page = \common\models\Page::find()->andWhere(['slug' => $slug])->one()) {
                /**
                 * @var PageTypePlugin $plugin
                 */
                if ($plugin = $page->type->plugin) {
                    if ($res[0] === $plugin::route($page)) {
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