<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $plugin
 * @property integer $status
 *
 * @property Page[] $pages
 */
class PageType extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \shirase\tree\TreeBehavior::className(),
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'route'], 'required'],
            [['status'], 'integer'],
            [['name', 'route'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'route' => Yii::t('common', 'Route'),
            'status' => Yii::t('common', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['view_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PageTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageTypeQuery(get_called_class());
    }
}
