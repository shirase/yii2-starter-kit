<?php
namespace common\plugins\page_type\page;

use common\components\db\ActiveRecord;

/**
 * Class Model
 * @method static Model|null findOne($condition)
 */
class Model extends ActiveRecord {

    public static function tableName()
    {
        return '{{%page_type_page}}';
    }

    public function formName()
    {
        return 'PageViewPage';
    }

    public function rules() {
        return [
            [['page_id', 'canonical'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'page_id'=>\Yii::t('common', 'Page'),
            'canonical'=>\Yii::t('common', 'Canonical'),
        ];
    }
}