<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\search\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form article-search" id="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'body') ?>

    <?php echo $form->field($model, 'created_by')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\User::find()->all(), 'id', 'username')]) ?>

    <?php //echo $form->field($model, 'updated_by')->widget(kartik\select2\Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(common\models\User::find()->all(), 'id', 'username')]) ?>

    <?php echo $form->field($model, 'status')->dropDownList([''=>'-', '1'=>Yii::t('backend', 'Yes'), '0'=>Yii::t('backend', 'No')]) ?>

    <?php //echo $form->field($model, 'published_at')->widget(DateRangePicker::classname(), ['hideInput'=>true, 'convertFormat'=>true, 'pluginOptions'=>['locale'=>['format'=>(($m=\Yii::$app->getModule('datecontrol')) ? \kartik\datecontrol\Module::parseFormat($m->displaySettings['date'], 'date') : 'Y-m-d')]]]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Reset'), Url::current(['TestSearch'=>null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('if(jQuery.pjax && jQuery("#article-grid-pjax").length) {jQuery(document).on(\'submit\', "#article-search form", function (event) {jQuery.pjax.submit(event, \'#article-grid-pjax\', {"push":true,"replace":false,"timeout":1000,"scrollTo":false});});}'); ?>
