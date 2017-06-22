<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
?>
<article class="page-view" itemscope itemtype="http://schema.org/CreativeWork">
    <h1 itemprop="headline"><?php echo $model->title ?: $model->name ?></h1>
    <div itemprop="text">
        <?php \frontend\widgets\InlineEditor::begin(['model'=>$model, 'attribute'=>'body']) ?>
        <?php echo $model->body ?>
        <?php \frontend\widgets\InlineEditor::end() ?>
    </div>
</article>