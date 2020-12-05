<?php

namespace common\models\query;

use common\models\OrdersApp;

/**
 * This is the ActiveQuery class for [[\common\models\OrdersApp]].
 *
 * @see \common\models\OrdersApp
 */
class OrdersAppQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => OrdersApp::STAT_SUCCEEDED])->orderBy(['viewed' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\OrdersApp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\OrdersApp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
