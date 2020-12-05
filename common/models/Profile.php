<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $last_donate
 * @property int $all_donate
 *
 * @property Chat[] $chats
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'last_donate', 'all_donate'], 'integer'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['name', 'phone'], 'filter', 'filter' => function ($value){
                return Html::encode($value);
            }],
            [['last_donate', 'all_donate'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'email',
            'last_donate' => 'Последнее пожертвование',
            'all_donate' => 'Всего пожертвований',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['profile_id' => 'id']);
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
     * @return \common\models\query\ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProfileQuery(get_called_class());
    }
}
