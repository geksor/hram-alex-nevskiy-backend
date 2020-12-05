<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $title
 * @property int $avail
 * @property int $publish
 * @property int $rank
 *
 * @property PriceItem[] $priceItems
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['avail', 'publish', 'rank'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'avail' => 'Доступно',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceItems()
    {
        return $this->hasMany(PriceItem::className(), ['price_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PriceQuery(get_called_class());
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
