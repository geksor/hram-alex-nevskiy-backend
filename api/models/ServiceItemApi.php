<?php

namespace api\models;

use common\models\ServiceItem;

class ServiceItemApi extends ServiceItem
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description',
        ];
    }
}
