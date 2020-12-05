<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service_item".
 *
 * @property int $id
 * @property int $service_id
 * @property string $title
 * @property string $description
 * @property int $publish
 * @property int $rank
 *
 * @property Service $service
 */
class ServiceItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'title'], 'required'],
            [['service_id', 'publish', 'rank'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'ID Услуги',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ServiceItemQuery(get_called_class());
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
