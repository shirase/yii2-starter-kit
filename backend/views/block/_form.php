<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
\shirase\pjax\PjaxAsset::register($this);
$this->registerJs('$(document).on("change", "#block-type_id", function() {$.pjax.submitForm($(this).closest("form"), "#type_plugin", {url: "'.\yii\helpers\Url::toRoute(['form', 'id'=>$model->id]).'"})})');
?>

<div class="block-form">

    <?php $form = ActiveForm::begin(['id'=>'block-form']); ?>

    <?= $form->field($model, 'vis')->dropDownList(['1'=>Yii::t('common', 'Yes'), '0'=>Yii::t('common', 'No')]) ?>

    <?= $form->field($model, 'type_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\BlockType::find()->orderBy('pos')->all(), 'id', 'name')]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php \yii\widgets\Pjax::begin(['id'=>'type_plugin']) ?>
    <?php
    if ($model->type_id && $plugin = $model->type->plugin) {
        /** @var $plugin \common\plugins\block_type\BlockTypePlugin */
        echo $plugin::widget($form, $model);
    }
    ?>
    <?php \yii\widgets\Pjax::end() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
