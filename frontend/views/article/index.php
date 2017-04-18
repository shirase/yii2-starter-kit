<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
$this->title = $this->title ?: Yii::t('frontend', 'Articles');
?>
<div id="article-index">
    <h1><?php echo Yii::t('frontend', 'Articles') ?></h1>
    <?php if (Yii::$app->user->can('administrator')): ?>
        <div class="editor-panel">
            <a class="j-frame-dialog link-create" data-type="create" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/create']) ?>" target="_blank"><?= Yii::t('frontend', 'Добавить') ?></a>
            |
            <a class="j-frame-dialog link-index" data-type="index" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/index']) ?>" target="_blank"><?= Yii::t('frontend', 'Список') ?></a>
        </div>
    <?php endif ?>
    <?php echo \yii\widgets\ListView::widget([
        'dataProvider'=>$dataProvider,
        'pager'=>[
            'hideOnSinglePage'=>true,
        ],
        'itemView'=>'_item',
        'viewParams' => ['category'=>$category],
    ])?>
</div>