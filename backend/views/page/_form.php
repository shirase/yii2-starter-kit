<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\components\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
\shirase\pjax\PjaxAsset::register($this);
$this->registerJs('$(document).on("change", "#page-type_id", function() {$.pjax.submitForm($(this).closest("form"), "#type_params", {url: "'.Url::toRoute(['form', 'id'=>$model->id]).'"})})');
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['id'=>'page-form']); ?>

    <?= $form->field($model, 'language')->dropDownList(Yii::$app->params['availableLocales']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Отображается в названии пункта меню и в заголовке страницы')) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php if ($model->pid || $model->pid===null): ?>

        <?= $form->field($model, 'status')->dropDownList(['1'=>Yii::t('backend', 'Yes'), '0'=>Yii::t('backend', 'No')]) ?>

        <?= $form->field($model, 'body')->widget(\yii\imperavi\Widget::className()) ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">SEO</div>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Заголовок страницы (тег H1)')) ?>
                <?= $form->field($model, 'page_title')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Заголовок страницы (тег title)')) ?>
                <?= $form->field($model, 'page_keywords')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'page_description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?php if ($model->pid!==null) echo $form->field($model, 'type_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\PageType::find()->orderBy('pos')->all(), 'id', 'name')]) ?>

        <?php Pjax::begin(['id'=>'type_params']) ?>
            <?php
                if ($model->type && $plugin = $model->type->plugin) {
                    /** @var \common\plugins\page_type\PluginInterface $plugin */
                    echo $plugin::widget($form, $model);
                }
            ?>
        <?php Pjax::end() ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ($r=ArrayHelper::getValue($this->context->actionParams, 'return')) ? $r : ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
