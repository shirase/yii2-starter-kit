<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\GalleryItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form gallery-item-search" id="gallery-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gallery_id')->widget(kartik\select2\Select2::class, ['data'=>[''=>'-']+ArrayHelper::map(common\models\Gallery::find()->all(), 'id', 'name')]) ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'title') ?>

    <?php //echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#gallery-item-grid-pjax").length) {jQuery(document).on(\'submit\', "#gallery-item-search form", function (event) {jQuery.pjax.submit(event, \'#gallery-item-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
