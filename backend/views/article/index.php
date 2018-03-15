<?php

use common\models\Article;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
/** @var \yii\web\Controller $controller */
$controller = $this->context;
$controller->layout = 'common';
?>
<div class="article-index">
    <div class="box collapsed-box">
        <div class="box-header">
            <div class="box-title" onclick="$.AdminLTE.boxWidget.collapse($(this).next().find('button'))" style="cursor: pointer">Поиск</div>
            <div class="box-tools pull-right"><button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button></div>
        </div>
        <div class="box-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <p>
                <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'id' => 'article-grid',
                'pjax' => true,
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'shirase\grid\sortable\SerialColumn'],

                    ['attribute'=>'published_at', 'format'=>'datetime'],
                    [
                        'attribute'=>'thumbnail',
                        'format' => 'raw',
                        'value' => function($model) {if ($model->thumbnail_path) return Html::img(\common\components\helpers\Url::image($model->thumbnail_path, ['w'=>100]));}
                    ],
                    ['attribute'=>'title'],
                    ['attribute'=>'slug'],
                    //['attribute'=>'author_id', 'value'=>function($model) {return $model->author->username;}],
                    [
                        'class' => '\pheme\grid\ToggleColumn',
                        'attribute' => 'status',
                    ],

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
                            },
                        'template' => '{home} {update} {delete}',
                        'buttons' => [
                            'home' => function ($url, Article $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-home"></span>',
                                    Yii::$app->urlManagerFrontend->createAbsoluteUrl(['article/view', 'slug'=>$model->slug, 'category'=>$model->category->id]),
                                    [
                                        'title' => Yii::t('backend', 'Site'),
                                        'data-pjax' => '0',
                                        'target' => '_top',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
