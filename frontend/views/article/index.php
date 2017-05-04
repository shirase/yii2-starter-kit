<?php
/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var \common\models\Page $category
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
                <h2 class="article-title" itemprop="name">
                    <?php echo \yii\helpers\Html::a($model->title, ['view', 'slug'=>$model->slug, 'category'=>$category->id], ['itemprop' => 'url']) ?>
                </h2>
                <div class="article-meta">
                    <time class="article-date" datetime="<?= encode($model->created_at) ?>" itemprop="dateline">
                        <?php echo Yii::$app->formatter->asDatetime($model->created_at) ?>
                    </time>
                </div>
                <div class="article-content">
                    <?php if ($model->thumbnail_path): ?>
                        <?php echo \yii\helpers\Html::img(
                            \common\components\helpers\Url::image($model->thumbnail_path, ['w' => 100]),
                            ['class' => 'article-thumb img-rounded pull-left', 'itemprop' => 'thumbnailUrl']
                        ) ?>
                    <?php endif; ?>
                    <div class="article-text">
                        <?php echo \yii\helpers\StringHelper::truncate($model->body, 150, '...', null, true) ?>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
        <?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    <?php endif ?>
</div>