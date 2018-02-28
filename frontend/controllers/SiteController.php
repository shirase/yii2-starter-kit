<?php
namespace frontend\controllers;

use common\models\Page;
use frontend\components\Seo;
use Yii;
use common\commands\SendEmailCommand;
use common\web\Controller;
use frontend\models\ContactForm;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    public function actionIndex()
    {
        $this->view->params['seoKey'] = 'index';
        Seo::make(new Page());

        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['adminEmail'])
                ->setFrom(Yii::$app->params['robotEmail'])
                ->setReplyTo([$model->email => $model->name])
                ->setSubject($model->subject)
                ->setTextBody($model->body)
                ->send())
            {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options'=>['class'=>'alert-success']
                ]);
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>\Yii::t('frontend', 'There was an error sending email.'),
                    'options'=>['class'=>'alert-danger']
                ]);
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    public function actionLang($lang) {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => Yii::$app->behaviors['locale']->cookieName,
            'value' => encode($lang),
            'expire' => strtotime('+1 year'),
        ]));
    }

    public function actionPing()
    {
        Yii::$app->session->open();
    }

    public function actionTestTime() {
        echo ini_get('date.timezone')."<br>";
        echo date('Y-m-d H:i:s e')."<br>";
        echo Yii::$app->formatter->asDatetime(time())."<br>";
        $now = Yii::$app->db->createCommand('SELECT NOW()')->queryScalar();
        echo $now."<br>";
        echo Yii::$app->formatter->asDatetime($now)."<br>";
    }

    public function actionTestMail() {
        \Yii::$app->commandBus->handle(new SendEmailCommand([
            'subject' => 'test',
            'body' => 'test',
            'to' => 'test@test.com',
        ]));
    }
}
