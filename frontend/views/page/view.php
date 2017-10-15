<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
?>
<article class="page_view" itemscope itemtype="http://schema.org/CreativeWork">
    <h1 itemprop="headline"><?php echo $model->title ?: $model->name ?></h1>
    <div itemprop="text">
        <?= \frontend\widgets\InlineEditor::widget(['model'=>$model, 'attribute'=>'body']) ?>
    </div>
</article>