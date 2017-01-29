<?php
namespace frontend\actions;

use yii\base\Action;
use Yii;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class UpdateAction extends Action
{
    /**
     * @var string|ActiveRecord
     */
    public $modelClass;

    public $role = 'administrator';

    public function run($id) {
        if (!Yii::$app->request->isAjax)
            throw new BadRequestHttpException();

        if (!Yii::$app->user->can($this->role))
            throw new ForbiddenHttpException();

        /**
         * @var ActiveRecord $model
         */
        $model = $this->modelClass;
        $model = $model::findOne($id);
        if (!$model)
            throw new NotFoundHttpException();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Yii::t('frontend', 'Saved');
        }

        throw new HttpException(500, 'Error');
    }
}