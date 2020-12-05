<?php

namespace common\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\common\models\Votes]].
 *
 * @see \common\models\Votes
 */
class VotesQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1])->andWhere(['<=', 'publish_at', Yii::$app->formatter->asTimestamp('now')]);
    }

    public function orderVotes()
    {
        return $this->orderBy(['votesCount' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Votes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Votes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
