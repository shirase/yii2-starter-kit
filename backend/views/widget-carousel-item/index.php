<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WidgetCarouselItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Widget Carousel Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (\Yii::$app->user->can('/'.$this->context->uniqueId.'/create')) echo Html::a(Yii::t('backend', 'Create'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Back'), ['widget-carousel/index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
    </p>
    <?php //Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '<div class="row">{items}</div>\n{pager}',
            'itemOptions' => ['class' => 'col-md-3'],
            'itemView' => '_item',
        ]) ?>
    <?php //Pjax::end(); ?>
</div>
