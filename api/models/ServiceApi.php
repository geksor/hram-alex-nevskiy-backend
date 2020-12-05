<?php

namespace api\models;

use common\models\MolebenItems;
use Yii;
use common\models\Service;

/**
 * Class ServiceApi
 * @package api\models
 *
 * @property ServiceItemApi[] $serviceItemsApi
 * @property \common\models\MolebenItems[] $molebenItems
 */
class ServiceApi extends Service
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceItemsApi()
    {
        return $this->hasMany(ServiceItemApi::className(), ['service_id' => 'id']);
    }

    /**
     * @return array|\common\models\MolebenItems[]
     */
    public function getMolebenItems()
    {
        $itemsArr = MolebenItems::find()->select('title')->active()->rankAsc()->asArray()->all();
        foreach ($itemsArr as &$item){
            $item['modify'] = 0;
        }
        return $itemsArr;
    }


    public function fields()
    {
        return [
            'id',
            'title',
            'image' => function () {
                return  Yii::$app->request->hostInfo . $this->getThumbImage();
            },
            'description',
            'type',
        ];
    }

    public function extraFields()
    {
        return [
            'items' => 'serviceItemsApi',
            'buttons' => function () {
                $buttons = [];
                switch ($this->type){
                    case self::TYPE_NAME:
                        $buttons = [['title' => self::TXT_DONATE, 'modify' => 0]];
                        break;
                    case self::TYPE_CANDIE:
                        $buttons = [['title' => self::TXT_FO_HEALTH, 'modify' => 1], ['title' => self::TXT_FO_REPOSE, 'modify' => 0]];
                        break;
                    case self::TYPE_MOLEBEN:
                        $buttons = $this->molebenItems;

                        break;
                    case self::TYPE_TWO_BUTTONS:
                        $buttons = [['title' => self::TXT_FO_HEALTH, 'modify' => 0], ['title' => self::TXT_FO_REPOSE, 'modify' => 0]];
                        break;
                }
                return $buttons;
            },
        ];
    }
}
