<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use common\components\helpers\Url;
?>
<article class="article_view" itemscope itemtype="http://schema.org/NewsArticle">
    <h1 itemprop="headline"><?php echo $this->title ?></h1>

    <?php if (Yii::$app->user->can('administrator')): ?>
        <div class="editor-panel">
            <a class="j-frame-dialog link-update" data-type="update" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['article/update', 'id'=>$model->id]) ?>" target="_blank"><?= Yii::t('frontend', 'Изменить') ?></a>
        </div>
    <?php endif ?>

    <?php if ($model->thumbnail_path): ?>
        <?php echo \yii\helpers\Html::img(
            Url::image($model->thumbnail_path, ['w' => 200]),
            ['class' => 'article-thumb img-rounded pull-left', 'itemprop' => 'thumbnailUrl']
        ) ?>
    <?php endif; ?>

    <div itemprop="text">
        <?= \frontend\widgets\InlineEditor::widget(['model'=>$model, 'attribute'=>'body']) ?>
    </div>

    <?php if (!empty($model->articleAttachments)): ?>
        <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
        <ul id="article-attachments">
            <?php foreach ($model->articleAttachments as $attachment): ?>
                <li>
                    <?php echo \yii\helpers\Html::a(
                        $attachment->name,
                        ['attachment-download', 'id' => $attachment->id])
                    ?>
                    (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</article>
