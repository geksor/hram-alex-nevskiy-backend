<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\SocNet]].
 *
 * @see \common\models\SocNet
 */
class SocNetQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return \common\models\SocNet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\SocNet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
