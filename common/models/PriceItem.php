<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "price_item".
 *
 * @property int $id
 * @property int $price_id
 * @property string $title
 * @property int $publish
 * @property int $rank
 *
 * @property Price $price
 */
class PriceItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_id', 'title'], 'required'],
            [['price_id', 'publish', 'rank'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => Price::className(), 'targetAttribute' => ['price_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_id' => 'ID Цены',
            'title' => 'Заголовок',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PriceItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PriceItemQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!$this->rank){
            $this->rank = 100;
        }
        return parent::beforeSave($insert);
    }
}
