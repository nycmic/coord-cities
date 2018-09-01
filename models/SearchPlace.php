<?php

namespace app\models;

use app\services\DistanceService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Place;

/**
 * SearchPlace represents the model behind the search form of `app\models\Place`.
 */
class SearchPlace extends Place
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['address', 'lat', 'lng'], 'safe'],
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
        $query = Place::find()->orderBy('address');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]]
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
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng]);

        return $dataProvider;
    }

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function sortByDistance($params)
	{
		$query = self::find();
		if(isset($params['SearchPlace']['id']) && !empty($params['SearchPlace']['id'])){
			$find = Place::find()->asArray()->all();
			$ids = DistanceService::calcProximity($find, Place::findOne(['address'=>Yii::$app->request->get('SearchPlace')['id']]));
			$query = Place::find()
			              ->where(['id' => $ids]) // find only needed id's
			              ->orderBy([new \yii\db\Expression('FIELD(id, '. implode(',', $ids) . ')')]);
		}

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
		]);

		$query->andFilterWhere(['like', 'address', $this->address])
		      ->andFilterWhere(['like', 'lat', $this->lat])
		      ->andFilterWhere(['like', 'lng', $this->lng]);

		return $dataProvider;
	}
}
