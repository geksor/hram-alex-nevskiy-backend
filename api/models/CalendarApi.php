<?php

namespace api\models;

use common\models\CalendarEvents;
use DateTimeZone;
use Yii;

/**
 * Class NewsApi
 * @package api\models
 * @property int $timezone
 */
class CalendarApi extends CalendarEvents
{

    public $timezone = 0;

    public function fields()
    {
        return [
            'from' => function() {
                $res = new \DateTime();
                $res->setTimestamp($this->start_day);
                $res->setTimezone(new DateTimeZone('UTC'));
                $res->setTime(0,0);
                return ($res->getTimestamp()+($this->timezone*60))*1000;
            },
            'to' => function() {
                $res = new \DateTime();
                $res->setTimestamp($this->stop_day);
                $res->setTimezone(new DateTimeZone('UTC'));
                $res->setTime(0,0);
                return ($res->getTimestamp()+($this->timezone*60))*1000;
            },
            'color',
        ];
    }
}
