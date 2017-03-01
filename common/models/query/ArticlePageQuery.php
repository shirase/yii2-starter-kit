<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ArticlePage]].
 *
 * @see \common\models\ArticlePage
 */
class ArticlePageQuery extends \common\components\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ArticlePage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ArticlePage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
