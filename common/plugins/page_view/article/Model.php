<?php
namespace common\plugins\page_view\article;

use common\components\db\ActiveRecord;

class Model extends ActiveRecord {

    public static function tableName()
    {
        return '{{%page_view_article}}';
    }

    public function formName()
    {
        return 'PageViewArticle';
    }

    public function rules() {
        return [
            [['category_id'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'category_id'=>\Yii::t('common', 'Category'),
        ];
    }
}