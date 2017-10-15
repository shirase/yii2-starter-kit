<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 */
?>
<section class="page_block">
    <?php if (Yii::$app->user->can('administrator')): ?>
        <div class="editor-panel">
            <a class="j-frame-dialog link-create" data-type="create" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['block/create', 'page_id'=>$model->id]) ?>" target="_blank"><?= Yii::t('frontend', 'Добавить блок') ?></a>
            |
            <a class="j-frame-dialog link-index" data-type="index" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['block/index', 'page_id'=>$model->id]) ?>" target="_blank"><?= Yii::t('frontend', 'Список блоков') ?></a>
        </div>
    <?php endif ?>
    <?php foreach (\common\models\Block::find()->orderBy('pos')->andWhere(['page_id' => $model->id])->all() as $block): ?>
        <?php
        /** @var \yii\base\Widget $widget */
        $widget = $block->type->widget;
        $config = $block->type->widget_param;
        if ($config) {
            $config = \yii\helpers\Json::decode($config);
        } else {
            $config = [];
        }
        $config['model'] = $block;
        echo $widget::widget($config);
        ?>
    <?php endforeach ?>
</section>