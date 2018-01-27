<?php

namespace common\models\query;
use common\models\PageType;

/**
 * This is the ActiveQuery class for [[\common\models\Page]].
 *
 * @see \common\models\Page
 *
 * @method PageQuery children($parent_id)
 */
class PageQuery extends \common\db\ActiveQuery
{

    public function behaviors() {
        return [
            'shirase\tree\TreeQueryBehavior'
        ];
    }

    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return \common\models\Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function type($pluginClass)
    {
        $pageType = PageType::findOne(['plugin' => $pluginClass]);
        if ($pageType) {
            $this->andWhere(['type_id' => $pageType->id]);
        } else {
            $this->andWhere('1=0');
        }

        return $this;
    }
}
