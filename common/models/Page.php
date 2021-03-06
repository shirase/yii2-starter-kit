<?php

namespace common\models;

use common\behaviors\UriBehavior;
use common\plugins\page_type\PageTypePlugin;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $language
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
 * @property PageType $type
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_description
 *
 * @property Page $parentPage
 *
 * @method int[] getPath()
 *
 * @method static Page|null findOne($condition)
 */
class Page extends \common\db\ActiveRecord
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
                'class' => TimestampBehavior::class,
                'value' => function() {return date(DATE_SQL);}
            ],
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true,
                'uniqueValidator' => [
                    'filter' => ['language' => Yii::$app->language]
                ],
            ],
            [
                'class' => \shirase\tree\TreeBehavior::class,
            ],
            [
                'class' => UriBehavior::class,
                'route' => function($model) {
                    if ($plugin = $model->type->plugin) {
                        return $plugin::route($model);
                    } else {
                        return 'page/view';
                    }
                },
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
            [['language'], 'string', 'max' => 5],
            [['page_title', 'page_keywords', 'page_description'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'string', 'max' => 1024],
            [['slug'], 'unique', 'targetAttribute'=>['slug', 'language']],
            [['name'], 'string', 'max' => 100],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageType::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'status' => Yii::t('common', 'Published'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'page_title' => Yii::t('common', 'Page title'),
            'page_keywords' => Yii::t('common', 'Page keywords'),
            'page_description' => Yii::t('common', 'Page description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PageType::class, ['id' => 'type_id']);
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
            /** @var PageTypePlugin $plugin */
            return $this->_dataModel = $plugin::model($this);
        }
    }

    public function getParentPage() {
        return $this->hasOne(Page::class, ['id'=>'pid']);
    }

    public function getUris() {
        return $this->hasMany(Uri::class, ['id'=>'uri_id'])->viaTable('page_uri', ['page_id'=>'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if (!$this->language && ($parent = $this->parentPage)) {
                $this->language = $parent->language;
            }
        }

        return parent::beforeSave($insert);
    }
}
