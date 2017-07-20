<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\Page;
use frontend\actions\UpdateAction;
use frontend\components\Breadcrumbs;
use frontend\components\Seo;
use frontend\models\search\ArticleSearch;
use Yii;
use common\components\web\Controller;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    public function actions() {
        return [
            'update'=>[
                'class'=>UpdateAction::className(),
                'modelClass'=>Article::className(),
            ]
        ];
    }

    /**
     * @param null $slug
     * @return string
     * @throws HttpException
     */
    public function actionIndex($slug=null)
    {
        $model = null;

        if ($slug) {
            $model = Page::findOne(['slug' => $slug]);
            if(!$model) {
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

        if ($model) {
            $ids = ArrayHelper::getColumn(Page::find()->children($model->id)->all(), 'id');
            if ($ids) {
                // With sub categories
                $ids[] = $model->id;

                $query = new Query();
                $query
                    ->from('article_page')
                    ->andWhere('article_page.article=article.id')
                    ->andWhere(['article_page.page' => $ids])
                ;
                $dataProvider->query->andWhere(['exists', $query]);
            } else {
                $categoryId = $model->id;

                /** @var ActiveQuery $query */
                $query = $dataProvider->query;
                $query->joinWith('categories')
                    ->andWhere(['article_page.page'=>$model->id]);
            }
        }

        $this->trigger('beforeRenderIndex');
        return $this->render('index', ['dataProvider'=>$dataProvider, 'category'=>$model, 'categoryId'=>$categoryId]);
    }

    /**
     * @param $slug
     * @param null $category
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug, $category=null)
    {
        $query = Article::find()->andWhere(['slug'=>$slug]);
        if (!Yii::$app->user->can('manager')) {
            $query->published();
        }
        $model = $query->one();
        if (!$model)
            throw new NotFoundHttpException();

        if ($category && $Category = Page::findOne($category)) {
            Breadcrumbs::make($Category, $model->title);
        }

        Seo::make($model);

        $this->trigger('beforeRenderView');
        return $this->render('view', ['model'=>$model]);
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
