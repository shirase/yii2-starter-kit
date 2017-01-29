<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace frontend\controllers;

use Yii;
use common\models\Page;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionView($slug)
    {
        $model = Page::find()->where(['slug'=>$slug, 'status'=>Page::STATUS_PUBLISHED])->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
        }

        if ($plugin = $model->type->plugin) {
            
        }

        return $this->render('view', ['model'=>$model]);
    }

    public function actionUpdate($id) {
        if (!Yii::$app->request->isAjax)
            throw new BadRequestHttpException();

        if (!Yii::$app->user->can('administrator'))
            throw new ForbiddenHttpException();

        $model = Page::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo 'OK';
            return;
        }

        throw new HttpException('Error');
    }
}
