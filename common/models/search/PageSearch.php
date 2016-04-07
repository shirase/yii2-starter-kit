<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Page;

/**
 * PageSearch represents the model behind the search form about `common\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'view_id', 'status', 'pid', 'pos'], 'integer'],
            [['slug', 'name', 'title', 'body', 'view_params_json', 'created_at', 'updated_at', 'bpath'], 'safe'],
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
        $query = Page::find()->indexBy($this::primaryKey()[0]);

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
        $query->andFilterWhere([
            'id' => $this->id,
            'view_id' => $this->view_id,
            'status' => $this->status,
            'pid' => $this->pid,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'view_params_json', $this->view_params_json])
            ->andFilterDateRange('created_at', $this->created_at)
            ->andFilterDateRange('updated_at', $this->updated_at)
            ->andFilterWhere(['like', 'bpath', $this->bpath]);

        return $dataProvider;
    }
}
