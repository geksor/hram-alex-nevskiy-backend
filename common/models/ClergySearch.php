<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Clergy;

/**
 * ClergySearch represents the model behind the search form of `common\models\Clergy`.
 */
class ClergySearch extends Clergy
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'birthday', 'name_day', 'jericho_ordination', 'deacon_ordination', 'publish', 'abbot'], 'integer'],
            [['name', 'chin', 'position', 'education', 'service_places', 'rewards', 'photo'], 'safe'],
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
        $query = Clergy::find();

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
            'birthday' => $this->birthday,
            'name_day' => $this->name_day,
            'jericho_ordination' => $this->jericho_ordination,
            'deacon_ordination' => $this->deacon_ordination,
            'publish' => $this->publish,
            'abbot' => $this->abbot,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'chin', $this->chin])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'service_places', $this->service_places])
            ->andFilterWhere(['like', 'rewards', $this->rewards])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
