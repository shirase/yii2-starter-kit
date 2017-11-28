<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_template".
 *
 * @property int $id
 * @property string $name
 * @property string $template
 *
 * @property PageTypeContent[] $pageTypeContents
 *
 * @method static PageTemplate|null findOne($condition)
 */
class PageTemplate extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_template';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'template'], 'string', 'max' => 100],
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
            'template' => Yii::t('common', 'Template'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageTypeContents()
    {
        return $this->hasMany(PageTypeContent::class, ['template_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PageTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PageTemplateQuery(get_called_class());
    }
}
