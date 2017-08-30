<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Seo;

/**
 * SeoSearch represents the model behind the search form of `common\models\Seo`.
 */
class SeoSearch extends Seo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'page_title', 'page_description', 'page_keywords', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Seo::find()->indexBy($this::primaryKey()[0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'page_description', $this->page_description])
            ->andFilterWhere(['like', 'page_keywords', $this->page_keywords])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
