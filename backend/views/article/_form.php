<?php

use common\components\helpers\TreeHelper;
use common\models\Page;
use kartik\select2\Select2;
use shirase55\filekit\widget\Upload;
use shirase55\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_ids')
        ->widget(
            Select2::className(),
            [
                'options'=>['multiple'=>true],
                'data'=>
                    TreeHelper::tab(
                        Page::find()->andWhere(['type_id'=>common\plugins\page_type\article\Plugin::getId()])->orderBy('bpath')->all()
                        , 'id', 'pid', 'name')
            ]) ?>

    <?php echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className()
    ) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(Upload::className());
    ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'sortable' => true,
            'maxNumberOfFiles' => 10
        ]);
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php echo $form->field($model, 'published_at')->widget(
        DateControl::className(),
        [
            'type'=>DateControl::FORMAT_DATETIME,
            'widgetClass'=>DateTimeWidget::className(),
            'options'=>[
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
