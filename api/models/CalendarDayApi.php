<?php

namespace api\models;

use common\models\CalendarEvents;

/**
 * Class NewsApi
 * @package api\models
 * @property string $date
 */
class CalendarDayApi extends CalendarEvents
{

    public $date = '';

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'date' => function() {
                return $this->date;
            },
        ];
    }
}
