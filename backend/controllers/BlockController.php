<?php

namespace backend\controllers;

use common\plugins\block_type\BlockTypePlugin;
use Yii;
use common\models\Block;
use common\models\search\BlockSearch;
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
 * BlockController implements the CRUD actions for Block model.
 */
class BlockController extends Controller
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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }

    /**
     * Lists all Block models.
     * @return mixed
     */
    public function actionIndex($page_id)
    {
        $searchModel = new BlockSearch();
        $searchModel->page_id = $page_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Block model.
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
     * Creates a new Block model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($page_id)
    {
        $model = new Block();
        $model->page_id = $page_id;

        $models = new MultiModel([
            $model,
        ]);

        if ($models->load(Yii::$app->request->post())) {
            $valid = true;
            $typeModel = null;
            $plugin = null;

            if ($model->type_id && $plugin = $model->type->plugin) {
                /** @var BlockTypePlugin $plugin */
                if ($typeModel = $plugin::model()) {
                    $typeModel->load(Yii::$app->request->post());
                    $valid = $valid & $typeModel->validate();
                }
            }

            $valid = $valid & $models->validate();

            if ($valid) {
                $tx = Yii::$app->db->beginTransaction();

                $valid = $models->save();
                if ($valid) {
                    if ($plugin && $typeModel) {
                        $plugin::link($typeModel, $model);
                        $valid = $typeModel->save();
                    }
                }

                if ($valid) {
                    $tx->commit();

                    Yii::$app->session->setFlash('script', '$(document).trigger("action.Create", '.Json::encode(['class'=>$model::className()]+$model->attributes).');');
                    return $this->redirect(['index', 'returned'=>true, 'page_id'=>$model->page_id]);
                } else {
                    $tx->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Block model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $models = new MultiModel([
            $model,
        ]);

        if ($models->load(Yii::$app->request->post())) {
            $valid = true;
            $typeModel = null;
            $plugin = null;

            if ($model->type_id && $plugin = $model->type->plugin) {
                /** @var BlockTypePlugin $plugin */
                if ($typeModel = $plugin::model($model)) {
                    $typeModel->load(Yii::$app->request->post());
                    $valid = $valid & $typeModel->validate();
                }
            }

            $valid = $valid & $models->validate();

            if ($valid) {
                $tx = Yii::$app->db->beginTransaction();

                $valid = $models->save();
                if ($valid) {
                    if ($plugin && $typeModel) {
                        $plugin::link($typeModel, $model);
                        $valid = $typeModel->save();
                    }
                }

                if ($valid) {
                    $tx->commit();

                    Yii::$app->session->setFlash('script', '$(document).trigger("action.Update", '.Json::encode(['class'=>$model::className()]+$model->attributes).');');
                    return $this->redirect(['index', 'returned'=>true, 'page_id'=>$model->page_id]);
                } else {
                    $tx->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionForm($id=null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Block();
        }

        $model->load(Yii::$app->request->post());

        return $this->renderPartial('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Block model.
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
            $model = $this->findModel($id);
            Yii::$app->session->setFlash('script', '$(document).trigger("action.Delete", '.Json::encode(['class'=>$model::className()]+$model->attributes).');');
            $model->delete();
            $this->redirect(['index', 'returned'=>true, 'page_id'=>$model->page_id]);
        }
    }

    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Block the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Block::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
