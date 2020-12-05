<?php

namespace common\models\query;

use common\models\DonatePay;

/**
 * This is the ActiveQuery class for [[\common\models\DonatePay]].
 *
 * @see \common\models\DonatePay
 */
class DonatePayQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => DonatePay::STAT_SUCCEEDED]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\DonatePay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\DonatePay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
