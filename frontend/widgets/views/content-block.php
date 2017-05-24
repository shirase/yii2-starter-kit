<?php
/**
 * @var \common\models\Block $model
 */
?>
<div class="content-block">
    <h3><?= encode($model->title) ?></h3>
    <?php \frontend\widgets\InlineEditor::begin(['model'=>$model, 'attribute'=>'body']) ?>
    <?php echo $model->body ?>
    <?php \frontend\widgets\InlineEditor::end() ?>
</div>