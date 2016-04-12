<?php

namespace common\models;

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
 * @property integer $view_id
 * @property string $view_params_json
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
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['body', 'view_params_json'], 'string'],
            [['view_params'], 'safe'],
            [['view_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'string', 'max' => 1024],
            [['slug'], 'unique'],
            [['name'], 'string', 'max' => 100],
            [['view_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageView::className(), 'targetAttribute' => ['view_id' => 'id']],
        ];
    }

    public function makeTitle() {
        return ($this->title ? $this->title : $this->name);
    }

    public function getView_params() {
        return $this->view_params_json ? Json::decode($this->view_params_json) : [];
    }

    public function setView_params($value) {
        $this->view_params_json = $value ? Json::encode($value) : '';
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
            'view_id' => Yii::t('common', 'View'),
            'view_params' => Yii::t('common', 'View Params'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getView()
    {
        return $this->hasOne(PageView::className(), ['id' => 'view_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageQuery(get_called_class());
    }
}
