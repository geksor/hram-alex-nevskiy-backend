<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SocNet;

/**
 * SocNetSearch represents the model behind the search form of `common\models\SocNet`.
 */
class SocNetSearch extends SocNet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'publish'], 'integer'],
            [['title', 'pre_link', 'image_svg', 'description'], 'safe'],
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
        $query = SocNet::find();

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
            'publish' => $this->publish,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'pre_link', $this->pre_link])
            ->andFilterWhere(['like', 'image_svg', $this->image_svg])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
