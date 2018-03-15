<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Seo */

$this->title = Yii::t('backend', 'SEO');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'SEO'), 'url' => ['index']];
?>
<?php if (!$model->isNewRecord): ?>
<div class="clearfix">
    <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->key], [
        'class' => 'pull-right btn btn-danger btn-xs',
        'data' => [
            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</div>
<?php endif ?>
<div class="seo-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
