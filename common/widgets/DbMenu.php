<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\widgets;

use common\models\Page;
use common\models\WidgetMenu;
use yii\base\InvalidConfigException;
use Yii;
use common\components\helpers\Url;
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

    private function makeItems($pid, &$tree) {
        if (!isset($tree[$pid])) return null;

        $items = [];
        foreach ($tree[$pid] as $id=>$row) {
            if (isset($tree[$id])) {
                $row['items'] = $this->makeItems($id, $tree);
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

        if (!$model) throw new HttpException(500);

        $tree = [];
        if ($rows = Page::find()->orderBy('bpath')->children($model->id)->all()) {
            foreach ($rows as $row) {
                $tree[$row->pid][$row->id] = ['label'=>$row->name, 'url'=>Url::routeFor($row)];
            }
        }

        $this->items = $this->makeItems($model->id, $tree);
    }
}
