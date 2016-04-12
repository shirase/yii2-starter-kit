<?php

namespace backend\controllers;

use Yii;
use common\models\PageView;
use common\models\search\PageViewSearch;
use common\components\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * PageViewController implements the CRUD actions for PageView model.
 */
class PageViewController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PageView models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            if (!Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update'))) {
                throw new HttpException(403);
            }

            $model = $this->findModel(Yii::$app->request->post('editableKey'));

            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['PageView']);
            $post = ['PageView' => $posted];

            if ($model->load($post)) {
                $model->save();
            }
            echo $out;
            return;
        }

        $searchModel = new PageViewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PageView model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!Yii::$app->user->can('/' . \common\components\helpers\Url::normalizeRoute('update'))) {
                throw new HttpException(403);
            }
            Yii::$app->session->setFlash('kv-detail-success', 'Saved record successfully');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model'=>$model]);
        }
    }

    /**
     * Creates a new PageView model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PageView();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'returned'=>true]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PageView model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'returned'=>true]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PageView model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
            $this->findModel($id)->delete();
            $this->redirect(['index', 'returned'=>true]);
        }
    }

    /**
     * Finds the PageView model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PageView the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PageView::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
