<?php

namespace common\models;


/**
 * This is the model class for table "donate_pay".
 *
 * @property int $id
 * @property int $user_id
 * @property int $donate_id
 * @property int $amount
 * @property int $status
 * @property string $pay_id
 * @property int $created_at
 *
 * @property Donate $donate
 * @property User $user
 */
class DonatePay extends \yii\db\ActiveRecord
{

    public const STAT_UNDEFINED = 0;
    public const STAT_PENDING = 1;
    public const STAT_SUCCEEDED = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donate_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'donate_id'], 'required'],
            [['user_id', 'donate_id', 'amount', 'status', 'created_at'], 'integer'],
            [['pay_id'], 'string', 'max' => 255],
            [['donate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donate::className(), 'targetAttribute' => ['donate_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['status', 'default', 'value' => self::STAT_UNDEFINED],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'donate_id' => 'Donate ID',
            'amount' => 'Amount',
            'status' => 'Status',
            'pay_id' => 'Pay ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonate(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Donate::className(), ['id' => 'donate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\DonatePayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DonatePayQuery(get_called_class());
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
