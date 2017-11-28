<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site_contact">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php Pjax::begin(['id' => 'contact_form_container', 'enablePushState' => false]) ?>
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['data-pjax' => true]]); ?>
                <?php echo $form->field($model, 'name') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'subject') ?>
                <?php echo $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'verifyCode')->widget(\himiklab\yii2\recaptcha\ReCaptcha::class)->label(false) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end() ?>
        </div>
    </div>

</div>
