<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 * @var $category \common\models\Page
 */
use yii\helpers\Html;
use common\components\helpers\Url;

?>
<hr/>
<div class="article-item row">
    <div class="col-xs-12">
        <?php if (Yii::$app->user->can('administrator')): ?>
            <div class="editor-panel">
                <a class="j-frame-dialog link-update" data-type="update" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/update', 'id'=>$model->id]) ?>" target="_blank"><?= Yii::t('frontend', 'Изменить') ?></a>
            </div>
        <?php endif ?>
        <h2 class="article-title">
            <?php echo Html::a($model->title, ['view', 'slug'=>$model->slug, 'category'=>$category->id]) ?>
        </h2>
        <div class="article-meta">
            <span class="article-date">
                <?php echo Yii::$app->formatter->asDatetime($model->created_at) ?>
            </span>,
        </div>
        <div class="article-content">
            <?php if ($model->thumbnail_path): ?>
                <?php echo Html::img(
                    Url::image($model->thumbnail_path, ['w' => 100]),
                    ['class' => 'article-thumb img-rounded pull-left']
                ) ?>
            <?php endif; ?>
            <div class="article-text">
                <?php echo \yii\helpers\StringHelper::truncate($model->body, 150, '...', null, true) ?>
            </div>
        </div>
    </div>
</div>
