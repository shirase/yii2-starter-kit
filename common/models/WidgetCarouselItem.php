<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use shirase55\filekit\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "widget_carousel_item".
 *
 * @property integer $id
 * @property integer $carousel_id
 * @property string $path
 * @property string $url
 * @property string $caption
 * @property integer $status
 * @property integer $pos
 *
 * @property WidgetCarousel $carousel
 *
 * @method static WidgetCarouselItem|null findOne($condition)
 */
class WidgetCarouselItem extends \common\components\db\ActiveRecord
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
        return 'widget_carousel_item';
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
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'image',
                'pathAttribute' => 'path',
                'urlAttribute' => 'imageUrl'
            ],
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::className(),
                'cacheComponent' => 'frontendCache',
                'keys' => [
                    function ($model) {
                        return [
                            WidgetCarousel::className(),
                            $model->carousel->key
                        ];
                    }
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_id'], 'required'],
            [['carousel_id', 'status'], 'integer'],
            [['path', 'url', 'caption'], 'string', 'max' => 1024],
            [['carousel_id'], 'exist', 'skipOnError' => true, 'targetClass' => WidgetCarousel::className(), 'targetAttribute' => ['carousel_id' => 'id']],
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
            'carousel_id' => Yii::t('common', 'Carousel ID'),
            'path' => Yii::t('common', 'Path'),
            'url' => Yii::t('common', 'Url'),
            'caption' => Yii::t('common', 'Caption'),
            'status' => Yii::t('common', 'Status'),
            'image' => Yii::t('common', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarousel()
    {
        return $this->hasOne(WidgetCarousel::className(), ['id' => 'carousel_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\WidgetCarouselItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WidgetCarouselItemQuery(get_called_class());
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
