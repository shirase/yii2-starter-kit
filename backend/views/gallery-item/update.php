<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GalleryItem */

$this->title = Yii::t('backend', 'Update: ', [
    'modelClass' => 'Gallery Item',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Gallery Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="clearfix">
    <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'pull-right btn btn-danger btn-xs',
        'data' => [
            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</div>
<div class="gallery-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
