<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div id="body_scroll">
    <div id="body_wrap">
        <?php if (Yii::$app->user->can('manager')): ?>
            <nav class="admin-menu" role="navigation">
                <div class="container">
                    <ul>
                        <li><a href="<?= encode(Yii::getAlias('@backendUrl')) ?>" tabindex="-1">Панель управления</a></li>
                        <?php if ($seoKey = \yii\helpers\ArrayHelper::getValue($this->params, 'seoKey')): ?>
                            <li><a class="j-frame-dialog" data-type="update" href="<?= Yii::$app->urlManagerBackend->createAbsoluteUrl(['seo/update', 'id'=>$seoKey]) ?>" tabindex="-1">Seo</a></li>
                        <?php endif ?>
                    </ul>
                </div>
            </nav>
        <?php endif ?>

        <?php echo $content ?>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="pull-left">&copy; My Company <?php echo date('Y') ?></div>
            <div class="pull-right"><?php echo Yii::powered() ?></div>
        </div>
    </footer>
</div>
<?php $this->endContent() ?>