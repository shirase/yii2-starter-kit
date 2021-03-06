<?php
/* @var $this yii\web\View */
use common\widgets\Script;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::$app->name;
?>
<div class="site_index">

    <?php echo \common\widgets\DbCarousel::widget([
        'key'=>'index',
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
    </div>

    <div class="body-content">
        <div class="row">
            <?php $contextBlock = \common\models\ContextBlock::get('home'); ?>
            <?php \frontend\widgets\InlineEditorBuilder::build($contextBlock, 'body')->begin() ?>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
            <?php \frontend\widgets\InlineEditorBuilder::end() ?>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <h2><?= \Yii::t('frontend', 'Contact') ?></h2>
                <div id="contact_form_holder"></div>
                <?php Script::begin() ?>
                <script>
                    $.ajax('<?= Url::to(['/site/contact']) ?>', {
                        headers: {
                            'X-PJAX': true,
                            'X-PJAX-Container': '#contact_form_holder'
                        },
                        success: function(html) {
                            var container = $('#contact_form_holder').html(html);
                            setTimeout(function() {
                                container.trigger('init');
                            }, 10);
                        }
                    });
                </script>
                <?php Script::end() ?>
            </div>
        </div>
    </div>
</div>
