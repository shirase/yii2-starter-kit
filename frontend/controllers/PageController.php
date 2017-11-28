<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace frontend\controllers;

use common\components\helpers\Url;
use common\models\PageTemplate;
use frontend\actions\UpdateAction;
use frontend\components\Breadcrumbs;
use frontend\components\Seo;
use Yii;
use common\models\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actions() {
        return [
            'update'=>[
                'class'=>UpdateAction::class,
                'modelClass'=>Page::class,
            ]
        ];
    }

    public function actionView($slug)
    {
        $query = Page::find()->andWhere(['slug'=>$slug]);
        if (!Yii::$app->user->can('manager')) {
            $query->active();
        }
        $model = $query->one();
        if (!$model || $model->pid === 0) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
        }

        Seo::make($model);
        Breadcrumbs::make($model);

        $template = 'view';

        if ($model->type_id > 2) {
            if ($plugin = $model->type->plugin) {
                $this->redirect(Url::pageUrl($model));
            }
        }
        elseif ($model->type_id == 1 && $template_id = $model->dataModel->template_id) {
            $template = PageTemplate::findOne($template_id)->template;
        }
        elseif ($model->type_id == 2) {
            $canonicalPage = Page::findOne($model->dataModel->page_id);
            if (!$canonicalPage)
                throw new NotFoundHttpException(Yii::t('frontend', 'Page not found'));
            if ($model->dataModel->canonical) {
                $this->view->registerLinkTag(['rel'=>'canonical', 'href'=>Url::pageUrl($canonicalPage)]);
                $model = $canonicalPage;
            } else {
                $this->redirect(Url::pageUrl($canonicalPage));
            }
        }

        $this->trigger('beforeRenderView');
        return $this->render($template, ['model'=>$model]);
    }
}
