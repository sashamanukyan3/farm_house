<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SiteSettings;

/**
 * SiteSettingsSearch represents the model behind the search form about `common\models\SiteSettings`.
 */
class SiteSettingsSearch extends SiteSettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ref_percent'], 'integer'],
            [['name', 'email', 'start_project'], 'safe'],
            [['min_paid'], 'number'],
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
        $query = SiteSettings::find();

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
            'min_paid' => $this->min_paid,
            'ref_percent' => $this->ref_percent,
            'start_project' => $this->start_project,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
