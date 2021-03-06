<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\Page;
use common\models\query\ArticleQuery;
use frontend\actions\UpdateAction;
use frontend\components\Breadcrumbs;
use frontend\components\Seo;
use frontend\models\search\ArticleSearch;
use Yii;
use common\web\Controller;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    public function actions()
    {
        return [
            'update' => [
                'class' => UpdateAction::class,
                'modelClass' => Article::class,
            ]
        ];
    }

    /**
     * @param null $slug
     * @return string
     * @throws HttpException
     */
    public function actionIndex($slug = null)
    {
        $model = null;

        if ($slug) {
            $model = Page::findOne(['slug' => $slug, 'language' => Yii::$app->language]);
            if (!$model) {
                throw new HttpException(404);
            }

            Seo::make($model);
            Breadcrumbs::make($model);
        }

        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search([]);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC]
        ];

        $categoryId = null;

        /** @var ArticleQuery $query */
        $query = $dataProvider->query;
        $query->published();

        if ($model) {
            $query->category($model->id);
        }

        $this->trigger('beforeRenderIndex');
        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => $model, 'categoryId' => $categoryId]);
    }

    /**
     * @param $slug
     * @param null $category
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug, $category = null)
    {
        $model = Article::find()->andWhere(['slug' => $slug, 'language' => Yii::$app->language])->one();
        if (!$model)
            throw new NotFoundHttpException();

        if (!Yii::$app->user->can('manager')) {
            if ($model->status != Article::STATUS_PUBLISHED) {
                throw new ForbiddenHttpException();
            }
        }

        if ($category && $Category = Page::findOne($category)) {
            Breadcrumbs::make($Category, $model->title);
        }

        $this->view->params['seoKey'] = 'article-' . $model->id;
        Seo::make($model);

        $this->trigger('beforeRenderView');
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }
}
