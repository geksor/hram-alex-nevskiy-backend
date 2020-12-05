<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "orders_app".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $service_name
 * @property string $service_action
 * @property string $icon_saint
 * @property int $amount
 * @property int $processed
 * @property int $created_at
 * @property int $viewed
 * @property string $pay_id
 * @property int $status
 *
 * @property User $user
 */
class OrdersApp extends \yii\db\ActiveRecord
{
    public const NOT_VIEWED = 0;
    public const NOT_PROCESSED = 1;
    public const PROCESSED = 2;

    public const STAT_UNDEFINED = 0;
    public const STAT_PENDING = 1;
    public const STAT_SUCCEEDED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_app';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'processed', 'created_at', 'viewed', 'status'], 'integer'],
            [['name', 'service_name', 'service_action', 'icon_saint', 'pay_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['viewed', 'default', 'value' => self::NOT_VIEWED],
            ['status', 'default', 'value' => self::STAT_UNDEFINED],
            [['name', 'icon_saint'], 'filter', 'filter' => function ($value){
                return Html::encode($value);
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'name' => 'Имя',
            'service_name' => 'Треба',
            'service_action' => 'Уточнение',
            'icon_saint' => 'Икона святого',
            'amount' => 'Сумма',
            'processed' => 'Исполнено',
            'created_at' => 'Дата создания',
            'viewed' => 'Просмотрено',
            'pay_id' => 'Pay ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrdersAppQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrdersAppQuery(get_called_class());
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Exception
     */
    public function beforeSave($insert)
    {
        if ($this->created_at){
            $this->created_at =
                is_string($this->created_at)
                    ? strtotime($this->created_at)
                    : $this->created_at;
        }else{
            $this->created_at = time();
        }

        return parent::beforeSave($insert);
    }
}
