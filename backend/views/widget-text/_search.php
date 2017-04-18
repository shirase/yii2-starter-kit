<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\search\WidgetTextSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form widget-text-search" id="widget-text-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'body') ?>

    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#widget-text-grid-pjax").length) {jQuery(document).on(\'submit\', "#widget-text-search form", function (event) {jQuery.pjax.submit(event, \'#widget-text-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
