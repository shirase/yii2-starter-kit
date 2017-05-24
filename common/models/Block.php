<?php

namespace common\models;

use common\plugins\block_type\BlockTypePlugin;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "block".
 *
 * @property int $id
 * @property int $pos
 * @property int $vis
 * @property int $page_id
 * @property int $type_id
 * @property string $title
 * @property string $body
 *
 * @property ActiveRecord $typeModel
 *
 * @property Page $page
 * @property BlockType $type
 * @property ActiveRecord $pluginModel
 *
 * @method static Block|null findOne($condition)
 */
class Block extends \common\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block';
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
            [['vis', 'page_id', 'type_id'], 'integer'],
            [['page_id', 'type_id', 'title'], 'required'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'vis' => Yii::t('common', 'Vis'),
            'page_id' => Yii::t('common', 'Page ID'),
            'type_id' => Yii::t('common', 'Type ID'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(BlockType::className(), ['id' => 'type_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\BlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BlockQuery(get_called_class());
    }

    private $_typeModel;

    public function getTypeModel() {
        if ($this->_typeModel) return $this->_typeModel;

        /** @var BlockTypePlugin $plugin */
        if ($this->type_id && $plugin = $this->type->plugin) {
            $this->_typeModel = $plugin::model($this);
        }

        return $this->_typeModel;
    }
}
