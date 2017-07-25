<?php

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */

$user = $model->getUser();
$profile = $model->getProfile()
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($user, 'username') ?>
    <?php echo $form->field($user, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordInput() ?>
    <?php echo $form->field($user, 'status')->dropDownList(User::statuses()) ?>

    <?php echo $form->field($profile, 'lastname') ?>
    <?php echo $form->field($profile, 'firstname') ?>
    <?php echo $form->field($profile, 'middlename') ?>

    <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
