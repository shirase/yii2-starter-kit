<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\WidgetCarouselItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form widget-carousel-item-search" id="widget-carousel-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'carousel_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\WidgetCarousel::find()->all(), 'id', 'name')]) ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'caption') ?>

    <?php //echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#widget-carousel-item-grid-pjax").length) {jQuery(document).on(\'submit\', "#widget-carousel-item-search form", function (event) {jQuery.pjax.submit(event, \'#widget-carousel-item-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
