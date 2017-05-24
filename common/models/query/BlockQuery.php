<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Block]].
 *
 * @see \common\models\Block
 */
class BlockQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Block[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Block|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
