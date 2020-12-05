<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tokens".
 *
 * @property int $id
 * @property int $user_id
 * @property int $token
 * @property int $expired_at
 *
 * @property User $user
 */
class Tokens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'expired_at'], 'required'],
            [['user_id', 'expired_at'], 'integer'],
            [['token'], 'unique'],
            [['token'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'token' => 'Token',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @param $expire
     * @throws \yii\base\Exception
     */
    public function generateToken($expire)
    {
        $this->expired_at = Yii::$app->formatter->asTimestamp($expire);
        $this->token = Yii::$app->security->generateRandomString();
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
     * @return \common\models\query\TokensQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TokensQuery(get_called_class());
    }

    public function fields()
    {
        return [
            'token',
            'expired_at',
        ];
    }

}
