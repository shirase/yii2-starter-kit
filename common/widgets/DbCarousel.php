<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\widgets;

use common\models\Gallery;
use common\models\GalleryItem;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

/**
 * Class DbCarousel
 * @package common\widgets
 */
class DbCarousel extends Carousel
{
    /**
     * @var
     */
    public $key;

    /**
     * @var array
     */
    public $controls = [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException;
        }
        $cacheKey = [
            Gallery::className(),
            $this->key
        ];
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = [];
            $query = GalleryItem::find()
                ->joinWith('gallery')
                ->where([
                    '{{%gallery_item}}.status' => GalleryItem::STATUS_ACTIVE,
                    '{{%gallery}}.status' => Gallery::STATUS_ACTIVE,
                    '{{%gallery}}.key' => $this->key,
                ])
                ->orderBy(['pos' => SORT_ASC]);
            foreach ($query->all() as $k => $item) {
                /** @var $item \common\models\GalleryItem */
                if ($item->path) {
                    $items[$k]['content'] = Html::img($item->getImageUrl());
                }

                if ($item->url) {
                    $items[$k]['content'] = Html::a($items[$k]['content'], $item->url, ['target'=>'_blank']);
                }

                if ($item->title) {
                    $items[$k]['caption'] = $item->title;
                }
            }
            Yii::$app->cache->set($cacheKey, $items, 60*60*24*365);
        }
        $this->items = $items;
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('carousel');
        $content = '';
        if (!empty($this->items)) {
            $content = implode("\n", [
                $this->renderIndicators(),
                $this->renderItems(),
                $this->renderControls()
            ]);
        }
        return Html::tag('div', $content, $this->options);
    }
}
