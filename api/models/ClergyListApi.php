<?php

namespace api\models;

use common\models\Clergy;
use Yii;

/**
 * Class ClergyListApi
 * @package api\models
 */
class ClergyListApi extends Clergy
{

    public function fields()
    {
        return [
            'id',
            'name',
            'chin',
            'position',
            'photo' => function () {
                return  Yii::$app->request->hostInfo . $this->getPrevImage();
            },
        ];
    }
}
