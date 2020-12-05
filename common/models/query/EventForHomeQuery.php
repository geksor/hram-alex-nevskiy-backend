<?php

namespace common\models\query;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the ActiveQuery class for [[\common\models\EventForHome]].
 *
 * @see \common\models\EventForHome
 */
class EventForHomeQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1])->andWhere(['<=', 'publish_at', Yii::$app->formatter->asTimestamp('today')]);
    }

    public function rankPublish()
    {
        return $this->orderBy(['publish_at' => SORT_DESC, 'id' => SORT_DESC]);
    }

    public function fromId($id, $type)
    {
        return $this->andWhere(['event_id' => $id, 'event_type' => $type]);
    }

    public function withEvent()
    {
        return $this->with('event');
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EventForHome[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EventForHome|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
