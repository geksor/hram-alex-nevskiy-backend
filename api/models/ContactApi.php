<?php

namespace api\models;

use common\models\Contact;
use common\models\ContactSocNet;
use Yii;

/**
 * Class ContactApi
 * @package api\models
 */
class ContactApi extends Contact
{

    public function fields()
    {
        return [
            'title',
            'timetable',
            'phone',
            'phoneWithText',
            'address',
            'index',
            'email',
            'image' => function () {
                return  Yii::$app->request->hostInfo . $this->getThumbImage();
            },
        ];
    }

    public function extraFields()
    {
        return [
            'socLinks' => function () {
                return $this->getSocLinks();
            }
        ];
    }

    public function getSocLinks()
    {
        return ContactSocNetApi::find()->active()->orderRank()->all();
    }
}
