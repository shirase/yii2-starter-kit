<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Uri]].
 *
 * @see \common\models\Uri
 */
class UriQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Uri[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Uri|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
