<?php

namespace common\models;

use shirase\yii2\behaviors\JsonifyBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $title
 * @property string $body
 * @property integer $type_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $pid
 * @property integer $pos
 * @property resource $bpath
 *
 * @property PageView $view
 */
class Page extends \common\components\db\ActiveRecord
{

    const STATUS_PUBLISHED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function() {return date(DATE_ISO8601);}
            ],
            'slug'=>[
                'class'=>SluggableBehavior::className(),
                'attribute'=>'name',
                'ensureUnique'=>true,
                'immutable'=>true
            ],
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
            [['name'], 'required'],
            [['body'], 'string'],
            [['type_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'string', 'max' => 1024],
            [['slug'], 'unique'],
            [['name'], 'string', 'max' => 100],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function makeTitle() {
        return ($this->title ? $this->title : $this->name);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'name' => Yii::t('common', 'Name'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'type_id' => Yii::t('common', 'Type'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PageType::className(), ['id' => 'type_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageQuery(get_called_class());
    }

    private $_dataModel;

    public function getDataModel() {
        if ($this->_dataModel) return $this->_dataModel;
        if ($plugin = $this->type->plugin) {
            return $this->_dataModel = $plugin::dataModel($this->id);
        }
    }
}
