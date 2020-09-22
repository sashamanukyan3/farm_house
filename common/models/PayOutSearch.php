<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayOut;

/**
 * PayOutSearch represents the model behind the search form about `common\models\PayOut`.
 */
class PayOutSearch extends PayOut
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'status_id'], 'integer'],
            [['amount'], 'number'],
            [['username', 'pay_type', 'purse'], 'string', 'max' => 255]
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
        $query = PayOut::find()->where(['status_id'=>1])->orderBy(['created_at'=>SORT_DESC]);

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
            'username' => $this->username,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'purse', $this->purse]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchList($params)
    {
        $query = PayOut::find()->orderBy(['created_at'=>SORT_DESC]);

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
            'username' => $this->username,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'purse', $this->purse]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOutedList($params)
    {
        $query = PayOut::find()->where(['status_id'=>2])->orderBy(['created_at'=>SORT_DESC]);

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
            'username' => $this->username,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'purse', $this->purse]);

        return $dataProvider;
    }
}
