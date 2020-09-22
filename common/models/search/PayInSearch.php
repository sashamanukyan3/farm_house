<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayIn;

/**
 * PayInSearch represents the model behind the search form about `common\models\PayIn`.
 */
class PayInSearch extends PayIn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created', 'fraud_count', 'complete'], 'integer'],
            [['username', 'purse', 'm_sign'], 'safe'],
            [['amount'], 'number'],
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
        $query = PayIn::find()->orderBy(['created'=>SORT_DESC]);

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
            'created' => $this->created,
            'amount' => $this->amount,
            'fraud_count' => $this->fraud_count,
            'complete' => $this->complete,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'purse', $this->purse])
            ->andFilterWhere(['like', 'm_sign', $this->m_sign]);

        return $dataProvider;
    }
}
