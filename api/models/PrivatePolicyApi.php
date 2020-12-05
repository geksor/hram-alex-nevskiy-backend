<?php

namespace api\models;

use common\models\PrivatePolicy;

/**
 * Class PrivatePolicyApi
 * @package api\models
 */
class PrivatePolicyApi extends PrivatePolicy
{

    public function fields()
    {
        return [
            'text',
        ];
    }
}
