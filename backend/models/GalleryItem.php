<?php

namespace backend\models;

class GalleryItem extends \common\models\GalleryItem
{
    public $images;

    public function rules() {
        return array_merge(parent::rules(), [
            [['images'], 'required']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'images' => \Yii::t('common', 'Images'),
        ]);
    }
}