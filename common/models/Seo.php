<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property string $key
 * @property string $page_title
 * @property string $page_description
 * @property string $page_keywords
 * @property string $title
 *
 * @method static Seo|null findOne($condition)
 */
class Seo extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['page_description', 'page_keywords'], 'string'],
            [['key'], 'string', 'max' => 100],
            [['page_title', 'title'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Key'),
            'page_title' => Yii::t('common', 'Page Title'),
            'page_description' => Yii::t('common', 'Page Description'),
            'page_keywords' => Yii::t('common', 'Page Keywords'),
            'title' => Yii::t('common', 'Title'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\SeoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SeoQuery(get_called_class());
    }
}
