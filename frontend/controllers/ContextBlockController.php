<?php
namespace frontend\controllers;

use common\models\ContextBlock;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class ContextBlockController extends Controller
{
    public function actionUpdate($id) {
        if (!\Yii::$app->request->isAjax)
            throw new BadRequestHttpException();

        if (!\Yii::$app->user->can('administrator'))
            throw new ForbiddenHttpException();

        $model = ContextBlock::findOne($id);
        if (!$model) {
            $model = new ContextBlock();
            $model->key = $id;
        }

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return \Yii::t('frontend', 'Saved');
        }

        throw new HttpException(500, 'Error');
    }
}