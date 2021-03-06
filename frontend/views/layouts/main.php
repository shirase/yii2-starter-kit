<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>
    <div class="container">
        <div class="main-menu">
            <?php echo common\widgets\DbMenu::widget([
                'key'=>'main-menu'
            ]) ?>
        </div>

        <?php echo Breadcrumbs::widget([
            'homeLink' => ['label'=>Yii::t('frontend', 'Главная'), 'url'=>'/'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if(Yii::$app->session->hasFlash('alert')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ])?>
        <?php endif; ?>

        <?php echo $content ?>
    </div>
<?php $this->endContent() ?>