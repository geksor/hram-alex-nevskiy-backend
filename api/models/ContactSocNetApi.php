<?php

namespace api\models;

use common\models\ContactSocNet;
use Yii;

/**
 * Class ContactSocNetApi
 * @package api\models
 */
class ContactSocNetApi extends ContactSocNet
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
