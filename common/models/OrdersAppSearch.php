<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrdersApp;

/**
 * OrdersAppSearch represents the model behind the search form of `common\models\OrdersApp`.
 */
class OrdersAppSearch extends OrdersApp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount', 'processed', 'created_at', 'viewed', 'status'], 'integer'],
            [['name', 'service_name', 'service_action', 'icon_saint', 'pay_id'], 'safe'],
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
        $query = OrdersApp::find()->active();

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
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'processed' => $this->processed,
            'created_at' => $this->created_at,
            'viewed' => $this->viewed,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'service_action', $this->service_action])
            ->andFilterWhere(['like', 'icon_saint', $this->icon_saint])
            ->andFilterWhere(['like', 'pay_id', $this->pay_id]);

        return $dataProvider;
    }
}
