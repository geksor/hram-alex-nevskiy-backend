<?php

namespace common\models;

use backend\firebase\FirebaseNotifications;
use yii\helpers\Html;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $profile_id
 * @property string $text
 * @property int $date
 * @property int $type
 * @property int $sended
 * @property int $viewed
 *
 * @property Profile $profile
 */
class Chat extends \yii\db\ActiveRecord
{
    const TYPE_ADMIN = 1;
    const TYPE_USER = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['profile_id', 'date', 'type', 'sended', 'viewed'], 'integer'],
            ['text', 'string', 'max' => 255],
            ['text', 'filter', 'filter' => function ($value){
                return Html::encode($value);
            }],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'text' => 'Text',
            'date' => 'Date',
            'type' => 'Type',
            'sended' => 'Sended',
            'viewed' => 'Viewed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ChatQuery(get_called_class());
    }

    /**
     * @param $name string
     * @return array|bool
     * @throws \Exception
     */
    public function sendNotice($name)
    {
        $notific = new FirebaseNotifications();

        $title = 'Сообщение из чата';
        $ids = null;
        $notification = [];


        if ((integer)$this->type === self::TYPE_ADMIN){
            $title = 'Администрация';
            $notification = [
                'title' => $title,
                'body' => $this->text,
                'sound' => 'default',
                'click_action' => 'FCM_PLUGIN_ACTIVITY'
            ];
        }
        if (((integer)$this->type === self::TYPE_USER) && $name) {
            $title = $name;
            $ids = ChatSubscrib::find()->select('token')->asArray()->all();
            $ids = \yii\helpers\ArrayHelper::getColumn($ids, 'token');
            $notification = [
                'title' => $title,
                'body' => $this->text,
                'sound' => 'default',
                'click_action' => 'admin/profile/'.$this->profile_id
            ];

        }

        $message = (integer)$this->type === self::TYPE_ADMIN
            ?[
                'name' => 'Администрация',
                'text' => $this->text,
                'date' => $this->date,
                'type' => 'received',
            ]
            :[
                'text' => $this->text,
                'date' => $this->date,
            ];

        $data = [
            'chat' => true,
            'link' => '/chat/',
            'profile_id' => $this->profile_id,
            'message' => $message
        ];

        if ($notific->sendNotification("/topics/chat_user_{$this->profile_id}", $notification, $data, $ids)){
            $this->sended = 1;
            return ['result' => 'success', 'message' => $message];
        }
        return false;
    }

}
