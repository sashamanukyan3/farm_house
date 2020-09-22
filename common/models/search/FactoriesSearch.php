<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Factories;

/**
 * FactoriesSearch represents the model behind the search form about `common\models\Factories`.
 */
class FactoriesSearch extends Factories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factory_id', 'level', 'energy', 'experience'], 'integer'],
            [['name', 'alias', 'img'], 'safe'],
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
        $query = Factories::find();

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
            'factory_id' => $this->factory_id,
            'price_to_buy' => $this->price_to_buy,
            'level' => $this->level,
            'energy' => $this->energy,
            'experience' => $this->experience,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
