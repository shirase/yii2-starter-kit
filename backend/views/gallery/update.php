<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = Yii::t('backend', 'Update: ') . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Gallery'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="gallery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
