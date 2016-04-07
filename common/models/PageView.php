<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_view".
 *
 * @property integer $id
 * @property string $name
 * @property string $route
 * @property integer $status
 *
 * @property Page[] $pages
 */
class PageView extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_view';
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
     * @return \common\models\query\PageViewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageViewQuery(get_called_class());
    }
}
