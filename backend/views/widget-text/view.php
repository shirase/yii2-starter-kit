<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetText */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Widget Texts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
        <!--<?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>-->
        <!--<?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
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
                'attribute'=>'id',
            ],
            [
                'attribute'=>'key',
            ],
            [
                'attribute'=>'title',
            ],
            [
                'attribute'=>'body',
                'format'=>'ntext',
            ],
            [
                'attribute'=>'status',
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