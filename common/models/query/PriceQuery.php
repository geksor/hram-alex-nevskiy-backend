<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Price]].
 *
 * @see \common\models\Price
 */
class PriceQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1]);
    }

    public function orderRank()
    {
        return $this->addOrderBy(['rank' => SORT_ASC]);
    }

    public function withItem()
    {
        return $this->with([
            'priceItems' =>
                function (PriceItemQuery $query) {
                $query->active()->orderRank();
            },
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Price[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Price|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
