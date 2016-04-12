<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PageView */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Page View',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Page Views'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="page-view-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
