<?php

namespace api\models;

use common\models\BlogSecond;
use common\models\Clergy;
use Yii;

/**
 * Class BlogSecondApi
 * @package api\models
 */
class BlogSecondApi extends BlogSecond
{

    public function fields()
    {
        return [
            'id',
            'title',
            'video_link',
            'avatar' => function () {
                if ($abbot = Clergy::getAbbot()){
                    return  Yii::$app->request->hostInfo . $abbot->getPrevImage();
                }
                return Yii::$app->request->hostInfo . '/no_image.png';
            },
            'publish_at' => function () {
                return 'Опубликованно ' . Yii::$app->formatter->asDate($this->publish_at, 'long');
            },
        ];
    }
}
