<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */

$this->title = Yii::t('backend', 'Create Widget Carousel Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Widget Carousel Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
