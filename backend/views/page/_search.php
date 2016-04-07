<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form page-search" id="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'body') ?>

    <?php //echo $form->field($model, 'view_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\PageView::find()->all(), 'id', 'name')]) ?>

    <?php //echo $form->field($model, 'view_params_json') ?>

    <?php //echo $form->field($model, 'status')->dropDownList([''=>'-', '1'=>Yii::t('common', 'Yes'), '0'=>Yii::t('common', 'No')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#page-grid-pjax").length) {jQuery(document).on(\'submit\', "#page-search form", function (event) {jQuery.pjax.submit(event, \'#page-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
