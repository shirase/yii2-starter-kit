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

class ArticleQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['{{%article}}.status' => Article::STATUS_PUBLISHED]);
        $this->andWhere('{{%article}}.published_at<NOW()');
        return $this;
    }
}
