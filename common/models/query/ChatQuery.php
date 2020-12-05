<?php

namespace common\models\query;

use common\models\Chat;

/**
 * This is the ActiveQuery class for [[\common\models\Chat]].
 *
 * @see \common\models\Chat
 */
class ChatQuery extends \yii\db\ActiveQuery
{
    public function noSended()
    {
        return $this->andWhere(['sended' => null]);
    }

    public function noViewedBackend()
    {
        return $this
            ->andWhere(['viewed' => null, 'type' => Chat::TYPE_USER])
            ->orderBy(['date' => SORT_DESC])
            ->with('profile');
    }

    public function afterDate($date)
    {
        return $this->andWhere(['>', 'date', $date]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Chat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Chat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
