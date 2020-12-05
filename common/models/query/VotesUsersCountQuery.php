<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\VotesUsersCount]].
 *
 * @see \common\models\VotesUsersCount
 */
class VotesUsersCountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\VotesUsersCount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\VotesUsersCount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
