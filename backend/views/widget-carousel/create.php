<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarousel */

$this->title = Yii::t('backend', 'Create Widget Carousel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Widget Carousels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
