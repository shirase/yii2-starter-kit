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
 * @property string $title
 * @property string $body
 * @property string $view_id
 * @property array $view_params
 * @property string $view_params_json
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $pid
 * @property integer $pos
 */
class Page extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
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
            [['body'], 'string'],
            [['view_params', 'safe']],
            [['status, view_id'], 'integer'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 1024],
            [['name'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 512],
        ];
    }

    public function makeTitle() {
        return ($this->title ? $this->title : $this->name);
    }

    public function getView_prams() {
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
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'view_id' => Yii::t('common', 'Page View'),
            'view_params' => Yii::t('common', 'View params'),
            'status' => Yii::t('common', 'Active'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
}
