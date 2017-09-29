<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "block_type".
 *
 * @property int $id
 * @property int $pos
 * @property string $name
 * @property string $widget
 * @property string $widget_param
 * @property string $plugin
 *
 * @property Block[] $blocks
 *
 * @method static BlockType|null findOne($condition)
 */
class BlockType extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block_type';
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
            [['name', 'widget'], 'required'],
            [['widget_param'], 'string'],
            [['name', 'widget', 'plugin'], 'string', 'max' => 100],
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
            'widget' => Yii::t('common', 'Widget'),
            'widget_param' => Yii::t('common', 'Widget Param'),
            'plugin' => Yii::t('common', 'Plugin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\BlockTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BlockTypeQuery(get_called_class());
    }
}
