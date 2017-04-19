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
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => '/',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]); ?>
            <?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
                    ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
                    [
                        'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                        'visible'=>!Yii::$app->user->isGuest,
                        'items'=>[
                            [
                                'label' => Yii::t('frontend', 'Settings'),
                                'url' => ['/user/default/index']
                            ],
                            [
                                'label' => Yii::t('frontend', 'Backend'),
                                'url' => Yii::getAlias('@backendUrl'),
                                'visible'=>Yii::$app->user->can('manager')
                            ],
                            [
                                'label' => Yii::t('frontend', 'Logout'),
                                'url' => ['/user/sign-in/logout'],
                                'linkOptions' => ['data-method' => 'post']
                            ]
                        ]
                    ],
                    [
                        'label'=>Yii::t('frontend', 'Language'),
                        'items'=>array_map(function ($code) {
                            return [
                                'label' => Yii::$app->params['availableLocales'][$code],
                                'url' => ['/site/set-locale', 'locale'=>$code],
                                'active' => Yii::$app->language === $code
                            ];
                        }, array_keys(Yii::$app->params['availableLocales']))
                    ]
                ]
            ]); ?>
            <?php NavBar::end(); ?>
            <div class="navbar navbar-holder"></div>
        <?php endif ?>

        <?php echo $content ?>

        <div id="footer-helper"></div>
        <footer id="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?php echo date('Y') ?></p>
                <p class="pull-right"><?php echo Yii::powered() ?></p>
            </div>
        </footer>
    </div>
</div>
<?php $this->endContent() ?>