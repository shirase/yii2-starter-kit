<?php
namespace backend\models;

use yii\base\Model;
use Yii;
use yii\db\ActiveQuery;

/**
 * Account form
 */
class AccountForm extends UserForm
{
    public $password_confirm;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['password_confirm'], 'compare', 'compareAttribute' => 'password']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'password_confirm' => Yii::t('backend', 'Password Confirm')
        ]);
    }
}
