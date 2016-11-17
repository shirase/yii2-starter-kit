<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="widget-carousel-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'image')->widget(\shirase55\filekit\widget\Upload::className()); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
