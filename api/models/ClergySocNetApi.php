<?php

namespace api\models;

use common\models\ClergySocNet;
use Yii;

/**
 * Class ClergySocNetApi
 * @package api\models
 */
class ClergySocNetApi extends ClergySocNet
{

    public function fields()
    {
        return [
            'id',
            'link' => function (){
                return $this->socNet->pre_link .'/'. $this->link;
            },
            'title' => function (){
                return $this->socNet->title;
            },
            'image' => function (){
                return $this->socNet->image_svg;
            }
        ];
    }
}
