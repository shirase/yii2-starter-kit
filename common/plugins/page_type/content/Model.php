<?php
namespace common\plugins\page_type\content;

use common\db\ActiveRecord;
use common\models\PageTemplate;

/**
 * Class Model
 * @method static Model|null findOne($condition)
 */
class Model extends ActiveRecord {

    public static function tableName()
    {
        return '{{%page_type_content}}';
    }

    public function formName()
    {
        return 'PageViewContent';
    }

    public function rules() {
        return [
            [['template_id'], 'integer'],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'template_id'=>\Yii::t('common', 'Template'),
        ];
    }
}