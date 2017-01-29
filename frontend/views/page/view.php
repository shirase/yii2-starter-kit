<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
$this->title = $this->title ?: $model->title;
?>
<div class="content">
    <h1><?php echo $model->title ?></h1>
    <?php \frontend\widgets\InlineEditor::begin(['model'=>$model, 'attribute'=>'body']) ?>
    <?php echo $model->body ?>
    <?php \frontend\widgets\InlineEditor::end() ?>
</div>