<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PageTemplate]].
 *
 * @see \common\models\PageTemplate
 */
class PageTemplateQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\PageTemplate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PageTemplate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
