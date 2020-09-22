<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'role', 'created_at', 'updated_at', 'sex', 'level', 'pay_pass', 'experience', 'energy', 'chat_status', 'chat_music', 'ref_id', 'is_subscribed', 'banned', 'need_experience', 'first_login', 'last_visited'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'birthday', 'city', 'country', 'about', 'photo', 'phone', 'refLink', 'banned_text', 'signup_date', 'login_date', 'signup_ip', 'last_ip', 'location'], 'safe'],
            [['for_pay', 'for_out', 'ref_for_out', 'outed'], 'number'],
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
        $query = User::find()->orderBy(['id'=>SORT_DESC]);

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
            'status' => $this->status,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sex' => $this->sex,
            'birthday' => $this->birthday,
            'level' => $this->level,
            'for_pay' => $this->for_pay,
            'for_out' => $this->for_out,
            'pay_pass' => $this->pay_pass,
            'experience' => $this->experience,
            'energy' => $this->energy,
            'chat_status' => $this->chat_status,
            'chat_music' => $this->chat_music,
            'ref_id' => $this->ref_id,
            'ref_for_out' => $this->ref_for_out,
            'is_subscribed' => $this->is_subscribed,
            'banned' => $this->banned,
            'need_experience' => $this->need_experience,
            'signup_date' => $this->signup_date,
            'first_login' => $this->first_login,
            'outed' => $this->outed,
            'last_visited' => $this->last_visited,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'refLink', $this->refLink])
            ->andFilterWhere(['like', 'banned_text', $this->banned_text])
            ->andFilterWhere(['like', 'login_date', $this->login_date])
            ->andFilterWhere(['like', 'signup_ip', $this->signup_ip])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
