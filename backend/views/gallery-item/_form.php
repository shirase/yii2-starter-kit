<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GalleryItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'images')->widget(
            \shirase55\filekit\widget\Upload::class,
            [
                'sortable' => true,
                'maxNumberOfFiles' => 100
            ]);
    } else {
        echo $form->field($model, 'image')->widget(\shirase55\filekit\widget\Upload::class);
    }
    ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->dropDownList(['1'=>Yii::t('backend', 'Published'), '0'=>Yii::t('backend', 'Draft')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
