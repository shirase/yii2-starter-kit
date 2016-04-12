<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\PageViewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form page-view-search" id="page-view-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'route') ?>

    <?= $form->field($model, 'status')->dropDownList([''=>'-', '1'=>Yii::t('common', 'Yes'), '0'=>Yii::t('common', 'No')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#page-view-grid-pjax").length) {jQuery(document).on(\'submit\', "#page-view-search form", function (event) {jQuery.pjax.submit(event, \'#page-view-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
