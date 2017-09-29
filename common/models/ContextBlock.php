<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "context_block".
 *
 * @property string $key
 * @property string $body
 *
 * @method static ContextBlock|null findOne($condition)
 */
class ContextBlock extends \common\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'context_block';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['body'], 'string'],
            [['key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Key'),
            'body' => Yii::t('common', 'Body'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ContextBlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ContextBlockQuery(get_called_class());
    }

    public static function get($key) {
        $model = self::findOne($key);
        if (!$model) {
            $model = new self();
            $model->key = $key;
        }
        return $model;
    }
}
