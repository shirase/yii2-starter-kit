<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ContextBlock]].
 *
 * @see \common\models\ContextBlock
 */
class ContextBlockQuery extends \common\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ContextBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ContextBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
