<?php
/**
 * @var $model \common\models\GalleryItem, the data model
 * @var $key integer, the key value associated with the data item
 * @var $index integer, the zero-based index of the data item in the items array returned by [[dataProvider]].
 * @var $widget \yii\widgets\ListView, this widget instance
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><span class="glyphicon glyphicon-sort" data-sortable-id="<?= encode($model->id) ?>"></span> <?= $model->title ?: $model->id ?></div>
    <div class="panel-body">
        <?= \yii\helpers\Html::img($model->getImageUrl(), ['style'=>'max-width:100%']) ?>
    </div>
    <div class="panel-footer">
        <?php
        if (\Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update'))) {
            echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id'=>$key], ['title'=>Yii::t('backend', 'Update'), 'data-pjax'=>0]);
        }
        if (\Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('delete'))) {
            echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span> ', ['delete', 'id'=>$key], ['title'=>Yii::t('backend', 'Delete')]);
        }
        ?>
    </div>
</div>
