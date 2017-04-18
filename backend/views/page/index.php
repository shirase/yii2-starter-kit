<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'id' => 'page-grid',
        'pjax' => true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'shirase\grid\sortable\SerialColumn'],

            ['class'=>'kartik\grid\BooleanColumn', 'attribute'=>'status'],
            'name',
            'slug',
            ['attribute'=>'type_id', 'value'=>function($model) {return $model->type->name;}],

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
