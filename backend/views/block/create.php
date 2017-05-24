<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $pluginModel common\plugins\block_type\operation_photo\Model */

$this->title = Yii::t('backend', 'Create Block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pluginModel' => $pluginModel,
    ]) ?>

</div>
