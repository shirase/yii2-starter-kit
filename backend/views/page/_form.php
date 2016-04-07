<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\yii\imperavi\Widget::className()) ?>

    <?= $form->field($model, 'view_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\PageView::find()->all(), 'id', 'name')]) ?>

    <?//= $form->field($model, 'view_params_json')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(['1'=>Yii::t('common', 'Yes'), '0'=>Yii::t('common', 'No')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
