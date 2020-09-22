<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AnimalFood;

/**
 * AnimalFoodSearch represents the model behind the search form about `common\models\AnimalFood`.
 */
class AnimalFoodSearch extends AnimalFood
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['animal_food_id', 'plant_id', 'min_count', 'energy', 'experience'], 'integer'],
            [['alias'], 'safe'],
            [['price_to_buy'], 'number'],
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
        $query = AnimalFood::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'animal_food_id' => $this->animal_food_id,
            'plant_id' => $this->plant_id,
            'price_to_buy' => $this->price_to_buy,
            'min_count' => $this->min_count,
            'energy' => $this->energy,
            'experience' => $this->experience,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
