<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleAttachment;
use common\models\Page;
use frontend\components\Breadcrumbs;
use frontend\components\Seo;
use frontend\models\search\ArticleSearch;
use Yii;
use common\components\web\Controller;
use yii\db\ActiveQuery;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @return string
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
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        if ($model) {
            /** @var ActiveQuery $query */
            $query = $dataProvider->query;
            $query->joinWith('categories')
                ->andWhere(['article_page.page'=>$model->id]);
        }

        $this->trigger('beforeRenderIndex');
        return $this->render('index', ['dataProvider'=>$dataProvider, 'category'=>$model]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug, $category=null)
    {
        $model = Article::find()->published()->andWhere(['slug'=>$slug])->one();
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
