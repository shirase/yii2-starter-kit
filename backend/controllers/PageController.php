<?php

namespace backend\controllers;

use kartik\grid\EditableColumnAction;
use Yii;
use common\models\Page;
use common\models\search\PageSearch;
use common\components\web\Controller;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\db\Expression;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
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
        return ArrayHelper::merge(parent::actions(), [
            'edit' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Page::className(),
                'showModelErrors' => true,
            ]
        ]);
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andFilterWhere(['IS', 'pid', new Expression('NULL')]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionMenu()
    {
        $this->actionParams['return'] = Url::current();

        $searchModel = new PageSearch();
        $searchModel->pid = '0';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('menu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($return=null)
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($return ? $return : ['index', 'returned'=>true]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $return=null)
    {
        $model = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dataModel = $model->dataModel;
            if (!$dataModel || ($dataModel->load(Yii::$app->request->post()) && $dataModel->save())) {
                $transaction->commit();
                return $this->redirect($return ? $return : ['index', 'returned'=>true]);
            }
        } else {
            $transaction->rollBack();
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionForm($id=null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Page();
        }

        $model->load(Yii::$app->request->post());

        return $this->renderPartial('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $return=null) {
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
            $this->redirect($return ? $return : ['index', 'returned'=>true]);
        }
    }

    public function actionTree($id)
    {
        $model = $this->findModel($id);
        return $this->render('tree', ['model'=>$model]);
    }

    public function actionJTree($root, $id=null) {
        if (!$id || $id=='#') {
            $id = $root;
        }

        $model = $this->findModel($id);

        $data = [
            [
                'id' => $model->id,
                'parent' => '#',
                'text' => $model->name,
                'state' => [
                    'opened' => true,
                ],
                'type' => 'page',
            ]
        ];

        if($rows = Page::find()->orderBy('pos')->children($id)->all()) {
            foreach ($rows as $row) {
                $data[] = [
                    'id' => $row->id,
                    'parent' => $row->pid,
                    'text' => $row->name,
                    'type' => 'page',
                ];
            }
        }

        return Json::encode($data);
    }

    public function actionJMove($id, $position, $parent)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException();
        }
        $model = $this->findModel($id);
        if ($position > 0) {
            if($node = Page::find()->orderBy('pos')->andWhere(['pid'=>$parent])->andFilterWhere(['!=', 'id', $model->id])->limit(1)->offset($position-1)->one()) {
                $model->insertAfter($node->id);
            }
        } else {
            if($node = Page::find()->orderBy('pos')->andWhere(['pid'=>$parent])->one()) {
                $model->insertBefore($node->id);
            }
        }
        return '{}';
    }

    public function actionJDelete($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException();
        }
        $model = $this->findModel($id);
        $model->delete();
        return '{}';
    }

    public function actionJRename($id, $name)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException();
        }
        $model = $this->findModel($id);
        $model->name = $name;
        $model->save();
        return '{}';
    }

    public function actionJCreate($parent, $name)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException();
        }
        $model = new Page();
        $model->pid = $parent;
        $model->name = $name;
        $model->save();
        return Json::encode(['id'=>$model->id]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
