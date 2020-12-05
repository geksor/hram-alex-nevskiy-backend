<?php

namespace api\models;

use common\models\News;
use Yii;

/**
 * Class NewsApi
 * @package api\models
 */
class NewsApi extends News
{

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'short_text',
            'image' => function () {
                return  Yii::$app->request->hostInfo . $this->getThumbImage();
            },
            'publish_at' => function () {
                return 'Опубликованно ' . Yii::$app->formatter->asDate($this->publish_at, 'long');
            },
        ];
    }
}
