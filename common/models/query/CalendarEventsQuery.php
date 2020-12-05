<?php

namespace common\models\query;

use DateTimeZone;

/**
 * This is the ActiveQuery class for [[\common\models\CalendarEvents]].
 *
 * @see \common\models\CalendarEvents
 */
class CalendarEventsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['publish' => 1]);
    }

    public function orderStartDay()
    {
        return $this->addOrderBy(['start_day' => SORT_ASC]);
    }

    /**
     * @param $dateStr
     * @return CalendarEventsQuery
     * @throws \Exception
     */
    public function filterMonth($dateStr)
    {
        $date = new \DateTime($dateStr);
        $prevMonth = $date->modify('-2 month')->getTimestamp();
        $date = new \DateTime($dateStr);
        $nextMonth = $date->modify('+3 month')->getTimestamp();

        return $this->andWhere(['>=', 'start_day', $prevMonth])->andWhere(['<', 'start_day', $nextMonth]);
    }
    /**
     * @param $dateStr
     * @return CalendarEventsQuery
     * @throws \Exception
     */
    public function filterDay($dateStr)
    {
        $date = new \DateTime($dateStr, new DateTimeZone('UTC'));
        $timestamp = $date->getTimestamp();

        return $this->andWhere(['<=', 'start_day', $timestamp])->andWhere(['>=', 'stop_day', $timestamp]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CalendarEvents[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CalendarEvents|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
