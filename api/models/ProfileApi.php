<?php

namespace api\models;

use common\models\Profile;
use Yii;

/**
 * Class NewsApi
 * @package api\models
 */
class ProfileApi extends Profile
{

    public function fields()
    {
        return [
            'id',
            'name',
            'phone',
            'email',
//            'last_donate',
//            'all_donate',
        ];
    }
}
