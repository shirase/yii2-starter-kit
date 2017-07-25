<?php

use common\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\AccountForm */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::t('backend', 'Edit account');

$user = $model->getUser();
$profile = $model->getProfile();
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($user, 'username') ?>

    <?php echo $form->field($user, 'email') ?>

    <?php echo $form->field($model, 'password')->passwordInput() ?>

    <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>

    <?php echo $form->field($profile, 'picture')->widget(\shirase55\filekit\widget\Upload::classname(), [
        'url'=>['avatar-upload']
    ]) ?>

    <?php echo $form->field($profile, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($profile, 'middlename')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($profile, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($profile, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?php /*echo $form->field($profile, 'gender')->dropDownlist([
        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
    ]) */ ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
