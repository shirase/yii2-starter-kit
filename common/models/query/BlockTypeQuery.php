<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\BlockType]].
 *
 * @see \common\models\BlockType
 */
class BlockTypeQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\BlockType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\BlockType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
