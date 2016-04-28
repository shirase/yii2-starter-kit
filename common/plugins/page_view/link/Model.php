<?php
namespace common\plugins\page_view\link;

use common\components\db\ActiveRecord;

class Model extends ActiveRecord {

    public static function tableName()
    {
        return '{{%page_view_link}}';
    }

    public function formName()
    {
        return 'PageViewLink';
    }

    public function rules() {
        return [
            [['link'], 'string', 'max'=>255],
        ];
    }

    public function attributeLabels() {
        return [
            'link'=>\Yii::t('common', 'Link'),
        ];
    }
}