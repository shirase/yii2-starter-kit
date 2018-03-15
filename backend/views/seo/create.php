<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Seo */

$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Seos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
