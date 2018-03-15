<?php

use common\components\helpers\TreeHelper;
use common\models\Page;
use kartik\select2\Select2;
use shirase55\filekit\widget\Upload;
use shirase55\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['id'=>'article-form']); ?>

    <?php if (sizeof(Yii::$app->params['availableLocales']) > 1) echo $form->field($model, 'language')->dropDownList(Yii::$app->params['availableLocales']) ?>

    <?php echo $form->field($model, 'status')->dropDownList(['1'=>Yii::t('backend', 'Published'), '0'=>Yii::t('backend', 'Draft')]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

    <?php
    $options = TreeHelper::tab(Page::find()->andWhere(['type_id'=>common\plugins\page_type\article\Plugin::getTypeId()])->orderBy('bpath')->all(), 'id', 'pid', 'name');
    if (sizeof($options)>1) {
        echo $form->field($model, 'category_ids')
            ->widget(
                Select2::class,
                [
                    'options'=>['multiple'=>true],
                    'data'=> $options
                ]);
    } else {
        if ($options) {
            echo Html::activeHiddenInput($model, 'category_ids[]', ['value'=>key($options)]);
        }
    }
    ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'body')->widget(
            \yii\imperavi\Widget::class
        );
    } else {
        echo '<div class="form-group">'.Html::activeLabel($model, 'body').'<br>'.Html::a(Yii::t('backend', 'Edit text on site'), Yii::$app->urlManagerFrontend->createAbsoluteUrl(['article/view', 'slug'=>$model->slug, 'category'=>$model->category->id]), ['target'=>'_blank']).'</div>';
    }
    ?>

    <?php echo $form->field($model, 'thumbnail')->widget(Upload::class); ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::class,
        [
            'sortable' => true,
            'maxNumberOfFiles' => 10
        ]);
    ?>

    <?php echo $form->field($model, 'published_at')->widget(
        DateControl::class,
        [
            'type'=>DateControl::FORMAT_DATETIME,
            'widgetClass'=>DateTimeWidget::class,
            'widgetOptions'=>[
                'clientOptions'=>['sideBySide'=>true],
                'clientEvents'=>[
                    'dp.change'=>new JsExpression('function(event) {$(this).find("input.form-control").trigger("change")}'),
                ],
            ]
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
