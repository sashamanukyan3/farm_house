<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Animals;

/**
 * AnimalsSearch represents the model behind the search form about `common\models\Animals`.
 */
class AnimalsSearch extends Animals
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['animal_id', 'level', 'weight', 'energy', 'experience'], 'integer'],
            [['name', 'img1', 'img2', 'img3', 'img4'], 'safe'],
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
        $query = Animals::find();

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
            'animal_id' => $this->animal_id,
            'level' => $this->level,
            'price_to_buy' => $this->price_to_buy,
            'weight' => $this->weight,
            'energy' => $this->energy,
            'experience' => $this->experience,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'img1', $this->img1])
            ->andFilterWhere(['like', 'img2', $this->img2])
            ->andFilterWhere(['like', 'img3', $this->img3])
            ->andFilterWhere(['like', 'img4', $this->img4]);

        return $dataProvider;
    }
}
