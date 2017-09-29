<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Seo]].
 *
 * @see \common\models\Seo
 */
class SeoQuery extends \common\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Seo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Seo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
