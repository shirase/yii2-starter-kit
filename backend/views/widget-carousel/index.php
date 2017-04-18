<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WidgetCarouselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Widget Carousels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create Widget'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'id' => 'widget-carousel-grid',
        'pjax' => true,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'shirase\grid\sortable\SerialColumn'],

            [
                'attribute'=>'key',
                'class' => \kartik\grid\EditableColumn::className(),
                'editableOptions'=> [
                    'formOptions' => ['action' => ['edit']],
                ]
            ],
            [
                'attribute'=>'status',
                'class' => \kartik\grid\EditableColumn::className(),
                //'refreshGrid' => true,
                'editableOptions'=> [
                    'formOptions' => ['action' => ['edit']],
                    //'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        0 => Yii::t('backend', 'Disabled'),
                        1 => Yii::t('backend', 'Enabled')
                    ],
                    'displayValueConfig' => [
                        0 => Yii::t('backend', 'Disabled'),
                        1 => Yii::t('backend', 'Enabled'),
                    ]
                ]
            ],
            /*[
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'status',
                'enum'=>[
                    Yii::t('backend', 'Disabled'),
                    Yii::t('backend', 'Enabled')
                ],
            ],*/

            [
                'class' => 'kartik\grid\ActionColumn',
                'visibleButtons'=>[
                    'view' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('view')),
                    'update' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update')),
                    'delete' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('delete')),
                    'items' => \Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('widget-carousel-item/index')),
                ],
                'buttons' => [
                    'items' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-edit']), Url::to(['widget-carousel-item/index', 'carousel'=>$key]+$this->context->actionParams), ['title'=>Yii::t('backend', 'Edit'), 'data-pjax'=>0]);
                    },
                ],
                'template' => '{items} {update} {delete}',
                'urlCreator' =>
                    function ($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : ['id' => (string) $key];
                        $params[0] = $action;
                        return Url::toRoute($params+$this->context->actionParams);
                    }
            ],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
