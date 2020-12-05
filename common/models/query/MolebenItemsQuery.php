<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\MolebenItems]].
 *
 * @see \common\models\MolebenItems
 */
class MolebenItemsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1]);
    }

    public function rankAsc()
    {
        return $this->orderBy(['rank' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\MolebenItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\MolebenItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
