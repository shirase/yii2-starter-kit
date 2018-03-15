<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'SEO');
$this->params['breadcrumbs'][] = $this->title;
/** @var \yii\web\Controller $controller */
$controller = $this->context;
$controller->layout = 'common';
?>
<div class="seo-index">
    <?php /* ?>
    <div class="box collapsed-box">
        <div class="box-header">
            <div class="box-title" onclick="$.AdminLTE.boxWidget.collapse($(this).next().find('button'))" style="cursor: pointer">Поиск</div>
            <div class="box-tools pull-right"><button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button></div>
        </div>
        <div class="box-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <?php */ ?>

    <div class="box">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <p>
                <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success', 'data-pjax'=>0]) ?>
            </p>
            <?= GridView::widget([
                'id' => 'seo-grid',
                'pjax' => true,
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['attribute'=>'key'],
                    ['attribute'=>'page_title'],
                    ['attribute'=>'title'],

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'visibleButtons'=>[
                            'view' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('view')),
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
    </div>
</div>
