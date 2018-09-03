<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Distance;

/**
 * SearchDistance represents the model behind the search form of `app\models\Distance`.
 */
class SearchDistance extends Distance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'from_id', 'to_id'], 'integer'],
            [['distance'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Distance::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['distance'=>SORT_ASC]]
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
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
        ]);

        $query->andFilterWhere(['like', 'distance', $this->distance]);

        return $dataProvider;
    }
}
