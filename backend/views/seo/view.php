<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\Seo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Seos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
        <!--<?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->key], ['class' => 'btn btn-primary']) ?>-->
        <!--<?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->key], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'key',
            ],
            [
                'attribute'=>'page_title',
            ],
            [
                'attribute'=>'page_description',
                'format'=>'ntext',
            ],
            [
                'attribute'=>'page_keywords',
                'format'=>'ntext',
            ],
            [
                'attribute'=>'title',
            ],
        ],
        'panel'=>[
            //'heading'=>(Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update')) ? $this->title : null),
        ],
        'deleteOptions'=>[
            'url' => ['delete', $model->primaryKey()[0]=>$model->primaryKey],
            'params' => ['j-delete' => true],
        ],
    ]) ?>

</div>
