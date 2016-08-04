<?php
namespace common\plugins\page_type\article;

use common\components\db\ActiveRecord;

/**
 * Class Model
 * @method static Model|null findOne($condition)
 */
class Model extends ActiveRecord {

    public static function tableName()
    {
        return '{{%page_type_article}}';
    }

    public function formName()
    {
        return 'PageViewArticle';
    }

    public function rules() {
        return [

        ];
    }

    public function attributeLabels() {
        return [

        ];
    }
}