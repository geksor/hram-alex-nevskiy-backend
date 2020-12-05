<?php

namespace api\models;

use common\models\Price;
use Yii;

/**
 *
 * @property PriceItemApi[] $priceItemsApi
 */
class PriceApi extends Price
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceItemsApi()
    {
        return $this->hasMany(PriceItemApi::className(), ['price_id' => 'id']);
    }


    public function fields()
    {
        return [
            'id',
            'title',
            'avail',
        ];
    }


    public function extraFields()
    {
        return [
            'items' => 'priceItemsApi',
        ];
    }


}
