<?php
/**
 * @var \common\models\Block $model
 */
?>
<div class="content-block">
    <h3><?= encode($model->title) ?></h3>
    <?= \frontend\widgets\InlineEditorBuilder::build($model, 'body') ?>
</div>