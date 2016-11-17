<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WidgetCarouselItem;

/**
 * WidgetCarouselItemSearch represents the model behind the search form of `common\models\WidgetCarouselItem`.
 */
class WidgetCarouselItemSearch extends WidgetCarouselItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'carousel_id', 'status', 'pos'], 'integer'],
            [['path', 'url', 'caption'], 'safe'],
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
        $query = WidgetCarouselItem::find()->indexBy($this::primaryKey()[0]);

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
            'carousel_id' => $this->carousel_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'caption', $this->caption]);

        return $dataProvider;
    }
}
