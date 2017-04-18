<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\search\WidgetCarouselSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form widget-carousel-search" id="widget-carousel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#widget-carousel-grid-pjax").length) {jQuery(document).on(\'submit\', "#widget-carousel-search form", function (event) {jQuery.pjax.submit(event, \'#widget-carousel-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
