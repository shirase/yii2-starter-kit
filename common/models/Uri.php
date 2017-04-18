<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "uri".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $redirect_id
 * @property integer $canonical_id
 * @property string $route
 * @property string $uri
 *
 * @property Page[] $pages
 * @property Uri $parent
 * @property Uri[] $uris
 *
 * @method static Uri|null findOne($condition)
 */
class Uri extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uri';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'redirect_id', 'canonical_id'], 'integer'],
            [['route', 'uri'], 'required'],
            [['route', 'uri'], 'string', 'max' => 1000],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Uri::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'parent_id' => Yii::t('common', 'Parent ID'),
            'redirect_id' => Yii::t('common', 'Redirect ID'),
            'canonical_id' => Yii::t('common', 'Canonical ID'),
            'route' => Yii::t('common', 'Route'),
            'uri' => Yii::t('common', 'Uri'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Uri::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\UriQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UriQuery(get_called_class());
    }
}
