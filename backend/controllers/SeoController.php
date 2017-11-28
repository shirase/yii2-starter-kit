<?php

namespace backend\controllers;

use Yii;
use common\models\Seo;
use common\models\search\SeoSearch;
use common\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use shirase\yii2\helpers\MultiModel;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }

    /**
     * Lists all Seo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Seo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Seo::findOne($id);
        if (!$model) {
            $model = new Seo();
            $model->key = $id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $valid = $model->save();

            if (Yii::$app->request->post('hasEditable')) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if (!$valid)
                    return ['output'=>'', 'message'=>reset($model->getFirstErrors())];

                return ['output'=>'', 'message'=>''];
            }

            if ($valid) {
                Yii::$app->session->setFlash('script', '$(document).trigger("action.Update", '.Json::encode(['class'=>$model::className()]+$model->attributes).');');
                return $this->redirect(['index', 'returned'=>true]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Seo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['j-delete'])) {
            if ($this->findModel($id)->delete()) {
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                    'kv-detail-info' => 'Successfully deleted. <a href="' .
                                                Url::to(['index']) . '" class="btn btn-sm btn-info">' .
                        '<i class="glyphicon glyphicon-hand-right"></i>  Click here</a> to proceed.'
                    ]
                ]);
            } else {
                echo Json::encode([
                    'success' => false,
                    'messages' => [
                        'kv-detail-error' => 'Cannot delete'
                    ]
                ]);
            }
            return;
        } else {
            $model = $this->findModel($id);
            Yii::$app->session->setFlash('script', '$(document).trigger("action.Delete", '.Json::encode(['class'=>$model::className()]+$model->attributes).');');
            $model->delete();
            if (!Yii::$app->request->isAjax) {
                $this->redirect(['index', 'returned'=>true]);
            }
        }
    }

    /**
     * Finds the Seo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Seo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
