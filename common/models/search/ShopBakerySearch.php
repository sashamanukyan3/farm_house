<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopBakery;

/**
 * ShopBakerySearch represents the model behind the search form about `common\models\ShopBakery`.
 */
class ShopBakerySearch extends ShopBakery
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'min_count_for_sell', 'energy', 'experience', 'energy_in_food'], 'integer'],
            [['name', 'alias', 'alias2', 'img', 'model_name'], 'safe'],
            [['price_for_sell', 'price_to_buy'], 'number'],
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
        $query = ShopBakery::find();

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
            'id' => $this->id,
            'price_for_sell' => $this->price_for_sell,
            'price_to_buy' => $this->price_to_buy,
            'level' => $this->level,
            'min_count_for_sell' => $this->min_count_for_sell,
            'energy' => $this->energy,
            'experience' => $this->experience,
            'energy_in_food' => $this->energy_in_food,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'alias2', $this->alias2])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'model_name', $this->model_name]);

        return $dataProvider;
    }
}
