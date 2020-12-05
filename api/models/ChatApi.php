<?php

namespace api\models;

use backend\firebase\FirebaseNotifications;
use common\models\Chat;

/**
 * Class ChatApi
 * @package api\models
 */
class ChatApi extends Chat
{

    public function fields()
    {
        if ($this->type === self::TYPE_ADMIN) {
            return [
                'name' => function (){return 'Администрация';},
                'text',
                'date',
                'type' => function (){return 'received';},
            ];
        }

       return [
            'text',
            'date',
        ];
    }
}
