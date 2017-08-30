<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Seo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'page_keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
