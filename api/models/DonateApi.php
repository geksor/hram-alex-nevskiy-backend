<?php

namespace api\models;

use common\models\Donate;

/**
 * Class DonateApi
 * @package api\models
 */
class DonateApi extends Donate
{

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'need',
            'now',
        ];
    }
}
