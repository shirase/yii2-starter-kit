<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\GalleryItem]].
 *
 * @see \common\models\GalleryItem
 */
class GalleryItemQuery extends \common\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\GalleryItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\GalleryItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
