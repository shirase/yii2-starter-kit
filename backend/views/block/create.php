<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Block */

$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
