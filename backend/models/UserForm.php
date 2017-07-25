<?php
namespace backend\models;

use common\models\User;
use common\models\UserProfile;
use yii\base\Model;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $password;
    public $roles;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required', 'on'=>'create'],
            ['password', 'string', 'min' => 6],

            [['roles'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getRoles(),
                    'name'
                )]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('backend', 'Password'),
            'roles' => Yii::t('backend', 'Roles')
        ];
    }

    private $_user;

    /**
     * @param User $model
     * @return mixed
     */
    public function setUser($model)
    {
        $this->_user = $model;
        $this->_profile = $model->userProfile;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        return $this->_user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = new User();
        }
        return $this->_user;
    }

    private $_profile;

    /**
     * @return UserProfile
     */
    public function getProfile() {
        if (!$this->_profile) {
            $this->_profile = new UserProfile();
        }
        return $this->_profile;
    }

    public function load($data, $formName = null) {
        return parent::load($data, $formName) & $this->getUser()->load($data) & $this->getProfile()->load($data);
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        return parent::validate($attributeNames, $clearErrors) & $this->getUser()->validate() & $this->getProfile()->validate();
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $profile = $this->getProfile();

            $transaction = $user->getDb()->beginTransaction();

            $isNewRecord = $user->getIsNewRecord();

            if ($this->password) {
                $user->setPassword($this->password);
            }
            if (!$user->save())
                throw new Exception('User save error', $user->errors);

            if ($isNewRecord) {
                $profile->user_id = $user->getId();
                $profile->locale = Yii::$app->language;
            }

            if (!$profile->save())
                throw new Exception('User profile save error', $profile->errors);

            if ($isNewRecord) {
                $user->afterSignup();
            }

            if (is_array($this->roles)) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($user->getId());
                if ($this->roles) {
                    foreach ($this->roles as $role) {
                        $auth->assign($auth->getRole($role), $user->getId());
                    }
                }
            }

            $transaction->commit();

            return true;
        }

        return null;
    }
}
