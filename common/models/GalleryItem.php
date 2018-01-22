<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use shirase55\filekit\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "gallery_item".
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string $path
 * @property string $url
 * @property string $title
 * @property integer $status
 * @property integer $pos
 *
 * @property Gallery $gallery
 *
 * @method static GalleryItem|null findOne($condition)
 */
class GalleryItem extends \common\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @var array|null
     */
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_item';
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            [
                'class' => \shirase\tree\TreeBehavior::class,
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'path',
                'urlAttribute' => 'imageUrl'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id'], 'required'],
            [['gallery_id', 'status'], 'integer'],
            [['path', 'url', 'title'], 'string', 'max' => 1024],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::class, 'targetAttribute' => ['gallery_id' => 'id']],
            [['image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'gallery_id' => Yii::t('common', 'Gallery'),
            'path' => Yii::t('common', 'Path'),
            'url' => Yii::t('common', 'Url'),
            'title' => Yii::t('common', 'Title'),
            'status' => Yii::t('common', 'Status'),
            'image' => Yii::t('common', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['id' => 'gallery_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\GalleryItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GalleryItemQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        if ($this->path && $this->path[0] === '/') {
            return rtrim(Yii::$app->urlManagerFrontend->hostInfo, '/') . '/' . ltrim($this->path, '/');
        } else {
            return rtrim(Yii::$app->fileStorage->baseUrl, '/') . '/' . ltrim($this->path, '/');
        }
    }
}
