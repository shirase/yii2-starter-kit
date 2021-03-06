<?php

namespace backend\controllers;

use common\models\Gallery;
use Yii;
use common\models\GalleryItem;
use common\models\search\GalleryItemSearch;
use common\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * GalleryItemController implements the CRUD actions for GalleryItem model.
 */
class GalleryItemController extends Controller
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
        return ArrayHelper::merge(parent::actions(), [
            'edit' => [
                'class' => EditableColumnAction::class,
                'modelClass' => GalleryItem::class,
                'showModelErrors' => true,
            ]
        ]);
    }

    /**
     * Lists all GalleryItem models.
     * @param null $gallery_id
     * @param null $key
     * @return mixed
     * @internal param $gallery
     */
    public function actionIndex($gallery_id = null, $key = null)
    {
        if ($key) {
            $gallery = Gallery::findOne(['key' => $key]);
            if (!$gallery) {
                $gallery = new Gallery();
                $gallery->key = $key;
                $gallery->status = Gallery::STATUS_DRAFT;
                $gallery->save();
            }

            $gallery_id = $gallery->id;
            $this->actionParams = ['gallery_id' => $gallery_id];
        }

        $searchModel = new GalleryItemSearch();
        $searchModel->gallery_id = $gallery_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GalleryItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $gallery_id
     * @return mixed
     * @throws HttpException
     * @internal param $gallery
     */
    public function actionCreate($gallery_id)
    {
        $model = new \backend\models\GalleryItem();
        $model->loadDefaultValues();
        $model->gallery_id = $gallery_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->images as $image) {
                $one = new GalleryItem();
                $one->setAttributes($model->attributes, false);
                $one->image = $image;
                if (!$one->save()) {
                    throw new HttpException(500, var_export($one->errors, true));
                }
            }

            return $this->redirect(['index', 'returned'=>true]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GalleryItem model.
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
     * Deletes an existing GalleryItem model.
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
     * Finds the GalleryItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
