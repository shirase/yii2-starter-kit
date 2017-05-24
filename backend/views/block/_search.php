<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\BlockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form block-search" id="block-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vis')->dropDownList([''=>'-', '1'=>Yii::t('common', 'Yes'), '0'=>Yii::t('common', 'No')]) ?>

    <?= $form->field($model, 'page_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\Page::find()->all(), 'id', 'name')]) ?>

    <?= $form->field($model, 'type_id')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\BlockType::find()->all(), 'id', 'name')]) ?>

    <?php //echo $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#block-grid-pjax").length) {jQuery(document).on(\'submit\', "#block-search form", function (event) {jQuery.pjax.submit(event, \'#block-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
