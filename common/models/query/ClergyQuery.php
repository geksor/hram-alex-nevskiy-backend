<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Clergy]].
 *
 * @see \common\models\Clergy
 */
class ClergyQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1]);
    }

    public function orderName()
    {
        return $this->orderBy(['name' => SORT_ASC]);
    }

    public function Abbot()
    {
        return $this->andWhere(['publish' => 1, 'abbot' => 1]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Clergy[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Clergy|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
