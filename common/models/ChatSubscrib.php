<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_subscrib".
 *
 * @property int $id
 * @property string $token
 */
class ChatSubscrib extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_subscrib';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ChatSubscribQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ChatSubscribQuery(get_called_class());
    }
}
