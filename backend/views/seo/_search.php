<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\SeoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form seo-search" id="seo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'page_title') ?>

    <?= $form->field($model, 'page_description') ?>

    <?= $form->field($model, 'page_keywords') ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['SeoSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#seo-grid-pjax").length) {jQuery(document).on(\'submit\', "#seo-search form", function (event) {jQuery.pjax.submit(event, \'#seo-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
