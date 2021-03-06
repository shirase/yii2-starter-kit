<?php

namespace common\models;

use common\behaviors\UriBehavior;
use common\components\helpers\Url;
use common\models\query\ArticleQuery;
use shirase55\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $thumbnail_path
 * @property string $thumbnail_url
 * @property array $attachments
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $language
 *
 * @property User $author
 * @property User $updater
 * @property ArticleAttachment[] $articleAttachments
 * @property Page[] $categories
 * @property Page $category
 */
class Article extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'value' => function() {return date(DATE_SQL);}
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'articleAttachments',
                'urlAttribute' => 'url',
                'pathAttribute' => 'path',
                'orderAttribute' => 'pos',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'urlAttribute' => 'thumbnail_url',
            ],
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::class,
                'relations' => [
                    'category_ids' => 'categories',
                ]
            ],
            [
                'class' => UriBehavior::class,
                'route' => 'article/view',
                'parents' => [
                    [
                        'relation'=>'categories',
                        'params' => [
                            'category' => 'id'
                        ],
                    ]
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['slug'], 'unique'],
            [['body'], 'string'],
            [['published_at'], 'default', 'value' => function () {
                return date(DATE_SQL);
            }],
            [['status'], 'integer'],
            [['language'], 'string', 'max' => 5],
            [['slug', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 255],
            [['attachments', 'thumbnail', 'category_ids'], 'safe']
        ];
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
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'status' => Yii::t('common', 'Published'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Author'),
            'updated_by' => Yii::t('common', 'Updater'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'category_ids' => Yii::t('common', 'Categories'),
            'attachments' => Yii::t('common', 'Attachments'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::class, ['article_id' => 'id']);
    }

    public function getCategories() {
        return $this->hasMany(Page::class, ['id'=>'page'])->viaTable('article_page', ['article'=>'id']);
    }

    public function getCategory() {
        return $this->hasOne(Page::class, ['id'=>'page'])->viaTable('article_page', ['article'=>'id']);
    }

    public function getThumbnail_url()
    {
        return Url::image($this->thumbnail_path, ['w'=>200]);
    }

    public function getUris() {
        return $this->hasMany(Uri::class, ['id'=>'uri_id'])->viaTable('article_uri', ['article_id'=>'id']);
    }
}
