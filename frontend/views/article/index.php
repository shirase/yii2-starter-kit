<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var \common\models\Page $category
 * @var int $categoryId
 */
$this->title = $this->title ?: Yii::t('frontend', 'Articles');
?>
<section class="article-index">
    <h1><?php echo Yii::t('frontend', 'Articles') ?></h1>
    <?php if (Yii::$app->user->can('administrator')): ?>
        <div class="editor-panel">
            <a class="j-frame-dialog link-create" data-type="create" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/create']) ?>" target="_blank"><?= Yii::t('frontend', 'Добавить') ?></a>
            |
            <a class="j-frame-dialog link-index" data-type="index" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/index']) ?>" target="_blank"><?= Yii::t('frontend', 'Список') ?></a>
        </div>
    <?php endif ?>
    <?php if ($models = $dataProvider->getModels()): ?>
        <?php foreach ($models as $model): ?>
            <?php /** @var \common\models\Article $model */ ?>
            <hr/>
            <article class="article-item" itemscope itemtype="http://schema.org/NewsArticle">
                <?php if (Yii::$app->user->can('administrator')): ?>
                    <div class="editor-panel">
                        <a class="j-frame-dialog link-update" data-type="update" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/update', 'id'=>$model->id]) ?>" target="_blank"><?= Yii::t('frontend', 'Изменить') ?></a>
                    </div>
                <?php endif ?>
                <h2 class="title" itemprop="name">
                    <?php echo \yii\helpers\Html::a($model->title, ['view', 'slug'=>$model->slug, 'category'=>$categoryId ?: $model->category->id], ['itemprop' => 'url']) ?>
                </h2>
                <div class="meta">
                    <time class="date" datetime="<?= encode($model->published_at) ?>" itemprop="dateline">
                        <?php echo Yii::$app->formatter->asDatetime($model->published_at) ?>
                    </time>
                </div>
                <?php if ($model->thumbnail_path): ?>
                    <div class="thumb">
                        <?php echo \yii\helpers\Html::img(
                            \common\components\helpers\Url::image($model->thumbnail_path, ['w' => 200]),
                            ['itemprop' => 'thumbnailUrl']
                        ) ?>
                    </div>
                <?php endif; ?>
                <div class="body">
                    <?php echo \yii\helpers\StringHelper::truncateWords(strip_tags($model->body), 25, '...') ?>
                </div>
            </article>
        <?php endforeach ?>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    <?php endif ?>
</section>