<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\widgets;

use common\models\Page;
use Yii;
use common\components\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\widgets\Menu;

/**
 * Class DbMenu
 * Usage:
 * echo common\widgets\DbMenu::widget([
 *      'key'=>'stored-menu-key',
 *      ... other options from \yii\widgets\Menu
 * ])
 * @package common\widgets
 */
class DbMenu extends Menu
{

    /**
     * @var string Key to find menu model
     */
    public $key;

    public $level;

    private $activeUrls = [];

    private function makeItems($pid, $level, &$tree) {
        if (!isset($tree[$pid]) || ($this->level && $level>$this->level)) return [];

        $items = [];
        foreach ($tree[$pid] as $id=>$row) {
            if (isset($tree[$id])) {
                $row['items'] = $this->makeItems($id, $level+1, $tree);
            }
            $items[] = $row;
        }
        return $items;
    }

    public function init()
    {
        if (is_numeric($this->key)) {
            $model = Page::findOne($this->key);
        } else {
            $model = Page::findOne(['slug'=>$this->key]);
        }

        if (!$model) throw new HttpException(500, 'Menu not found');

        $this->activeUrls[] = rtrim(Yii::$app->request->baseUrl, '/') . '/' . Yii::$app->request->pathInfo;

        $view = \Yii::$app->controller->view;
        if ($breadcrumbs = ArrayHelper::getValue($view->params, 'breadcrumbs')) {
            foreach ($breadcrumbs as $row) {
                if ($url = ArrayHelper::getValue($row, 'url')) {
                    $this->activeUrls[] = $url;
                }
            }
        }

        $tree = [];
        if ($rows = Page::find()->active()->orderBy('bpath')->children($model->id)->all()) {
            foreach ($rows as $row) {
                if (!isset($tree[$row->pid])) $tree[$row->pid] = [];
                $tree[$row->pid][$row->id] = ['label'=>$row->name, 'url'=>Url::pageUrl($row)];
            }
        }

        $this->items = $this->makeItems($model->id, 1, $tree);
    }

    protected function isItemActive($item) {
        if ($url = ArrayHelper::getValue($item, 'url')) {
            if (array_search($url, $this->activeUrls)!==false) {
                return true;
            }
        }
        return false;
    }
}
