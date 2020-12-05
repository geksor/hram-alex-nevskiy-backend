<?php

namespace api\models;

use common\models\Clergy;
use Yii;

/**
 * Class ClergyApi
 * @package api\models
 *
 * @property ClergySocNetApi[] $clergySocNetsApi
 */
class ClergyApi extends Clergy
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClergySocNetsApi()
    {
        return $this->hasMany(ClergySocNetApi::className(), ['clergy_id' => 'id']);
    }


    public function fields()
    {
        return [
            'id',
            'name',
            'chin',
            'position',
            'birthday' => function () {
                return $this->birthday?Yii::$app->formatter->asDate($this->birthday, 'long'):'';
            },
            'name_day' => function () {
                return $this->name_day?Yii::$app->formatter->asDate($this->name_day, 'd MMMM'):'';
            },
            'jericho_ordination' => function () {
                return $this->jericho_ordination?Yii::$app->formatter->asDate($this->jericho_ordination, 'long'):'';
            },
            'deacon_ordination' => function () {
                return $this->deacon_ordination?Yii::$app->formatter->asDate($this->deacon_ordination, 'long'):'';
            },
            'education',
            'service_places',
            'rewards',
            'photo' => function () {
                return  Yii::$app->request->hostInfo . $this->getThumbImage();
            },
            'abbot',
            'socNets' => 'clergySocNetsApi'
        ];
    }
}
