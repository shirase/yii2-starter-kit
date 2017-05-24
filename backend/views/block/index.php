<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Blocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create Block'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'id' => 'block-grid',
        'pjax' => true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'shirase\grid\sortable\SerialColumn'],

            ['class'=>'kartik\grid\BooleanColumn', 'attribute'=>'vis'],
            ['attribute'=>'type_id', 'value'=>function($model) {return $model->type->name;}],
            ['attribute'=>'title'],

            [
                'class' => 'kartik\grid\ActionColumn',
                'visibleButtons'=>[
                    'view' => false,
                    'update' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update')),
                    'delete' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('delete')),
                ],
                'urlCreator' =>
                    function ($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : ['id' => (string) $key];
                        $params[0] = $action;
                        return Url::toRoute($params+$this->context->actionParams);
                    }
            ],
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
