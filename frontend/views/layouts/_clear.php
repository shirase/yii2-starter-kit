<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Html::encode(ArrayHelper::getValue($this->params, 'page_title') ?: $this->title) ?></title>
    <?php $this->head() ?>
    <?php if (http_response_code() != 404) echo Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
<?php $this->beginBody() ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
<script>
    setInterval(function() {
        $.ajax('<?= \yii\helpers\Url::to(['site/ping']) ?>');
    }, 100000);
</script>
</body>
</html>
<?php $this->endPage() ?>
