<?php

namespace api\models;

use common\models\UsefulLinks;

/**
 * Class UsefulLinksApi
 * @package api\models
 */
class UsefulLinksApi extends UsefulLinks
{

    public function fields()
    {
        return [
            'id',
            'title',
            'link',
        ];
    }
}
