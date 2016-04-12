<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PageViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Page Views');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create Page View'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'id' => 'page-view-grid',
        'pjax' => true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'shirase\grid\sortable\SerialColumn'],

            'name',
            'route',
            ['class'=>'kartik\grid\BooleanColumn', 'attribute'=>'status'],

            [
                'class' => 'kartik\grid\ActionColumn',
                'visibleButtons'=>[
                    'view' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('view')),
                    'update' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update')),
                    'delete' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('delete')),
                ],
            ],
        ],
    ]); ?>
</div>
