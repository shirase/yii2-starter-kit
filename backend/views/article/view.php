<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

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
                'attribute'=>'slug',
            ],
            [
                'attribute'=>'title',
            ],
            [
                'attribute'=>'thumbnail',
                'format' => 'raw',
                'value' => Html::img(\common\components\helpers\Url::image($model->thumbnail_path, ['w'=>100])),
            ],
            [
                'attribute'=>'body',
                'format'=>'ntext',
            ],
            ['attribute'=>'created_by', 'value'=>$model->author->username],
            ['attribute'=>'updated_by', 'value'=>$model->updater->username],
            [
                'attribute'=>'status',
                'format'=>'boolean',
                'type'=>DetailView::INPUT_CHECKBOX,
            ],
            [
                'attribute'=>'published_at',
                'format'=>'datetime',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE,
                    'saveFormat'=>(($m = Yii::$app->getModule('datecontrol')) ? $m->saveSettings['datetime'] : 'php:Y-m-d H:i:s'),
                ]
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
