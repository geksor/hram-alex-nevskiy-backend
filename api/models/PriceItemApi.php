<?php

namespace api\models;

use common\models\PriceItem;

class PriceItemApi extends PriceItem
{
    public function fields()
    {
        return [
          'id',
          'title',
        ];
    }
}
