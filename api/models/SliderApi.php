<?php

namespace api\models;

use common\models\Slider;

/**
 * Class NewsApi
 * @package api\models
 */
class SliderApi extends Slider
{

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'link',
        ];
    }
}
