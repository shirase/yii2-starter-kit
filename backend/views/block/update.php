<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Block */

$this->title = Yii::t('backend', 'Update: ', [
    'modelClass' => 'Block',
]) . $model->title;
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="block-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
