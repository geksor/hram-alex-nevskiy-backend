<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Slider]].
 *
 * @see \common\models\Slider
 */
class SliderQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1]);
    }

    public function orderRank()
    {
        return $this->addOrderBy(['rank' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Slider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Slider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
