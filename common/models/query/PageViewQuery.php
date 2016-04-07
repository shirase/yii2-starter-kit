<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PageView]].
 *
 * @see \common\models\PageView
 */
class PageViewQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\PageView[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PageView|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
