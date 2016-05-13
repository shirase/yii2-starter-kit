<?php

use common\components\helpers\TreeHelper;
use common\models\Page;
use kartik\widgets\Select2;
use shirase\form\ActiveForm;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\bootstrap\ActiveForm */
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
                        Page::find()->andFilterWhere(['type_id'=>common\plugins\page_type\article\Plugin::getId()])->orderBy('bpath')->all()
                        , 'id', 'pid', 'name')
            ]) ?>

    <?php echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php echo $form->field($model, 'published_at')->widget(
        \kartik\date\DatePicker::className()
    ) ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
