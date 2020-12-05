<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ContactSocNet]].
 *
 * @see \common\models\ContactSocNet
 */
class ContactSocNetQuery extends \yii\db\ActiveQuery
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
     * @return \common\models\ContactSocNet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ContactSocNet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
