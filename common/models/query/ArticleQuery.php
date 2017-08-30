<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\components\db\ActiveQuery;
use common\models\Article;
use common\models\Page;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class ArticleQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['{{%article}}.status' => Article::STATUS_PUBLISHED]);
        $this->andWhere('{{%article}}.published_at<NOW()');
        return $this;
    }

    public function category($categoryId) {
        $ids = ArrayHelper::getColumn(Page::find()->children($categoryId)->all(), 'id');
        if ($ids) {
            // With sub categories
            $ids[] = $categoryId;

            $query = new Query();
            $query
                ->from('article_page')
                ->andWhere('article_page.article=article.id')
                ->andWhere(['article_page.page' => $ids])
            ;
            $this->andWhere(['exists', $query]);
        } else {
            $this->joinWith('categories')
                ->andWhere(['article_page.page'=>$categoryId]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
