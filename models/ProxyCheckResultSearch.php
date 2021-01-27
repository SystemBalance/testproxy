<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProxyCheckResult;

/**
 * ProxyCheckResultSearch represents the model behind the search form of `app\models\ProxyCheckResult`.
 */
class ProxyCheckResultSearch extends ProxyCheckResult
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'check_id', 'proxy_id', 'type', 'ip_addr', 'status', 'timeout'], 'integer'],
            [['created_at', 'updated_at', 'ip_geo_country', 'ip_geo_city'], 'safe'],
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
        $query = ProxyCheckResult::find();

        // add conditions that should always apply here

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
            'check_id' => $this->check_id,
            'proxy_id' => $this->proxy_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'ip_addr' => $this->ip_addr,
            'status' => $this->status,
            'timeout' => $this->timeout,
        ]);

        $query->andFilterWhere(['like', 'ip_geo_country', $this->ip_geo_country])
            ->andFilterWhere(['like', 'ip_geo_city', $this->ip_geo_city]);

        return $dataProvider;
    }
}
