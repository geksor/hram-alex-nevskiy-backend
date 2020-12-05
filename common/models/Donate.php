<?php

namespace common\models;

use backend\firebase\FirebaseNotifications;
use Yii;

/**
 * This is the model class for table "donate".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $need
 * @property int $now
 * @property int $publish
 * @property int $rank
 * @property int $created_at
 * @property int $last_donate
 * @property int $last_donate_date
 * @property int $donate_count
 * @property int $sended
 *
 * @property DonatePay[] $donatePays
 */
class Donate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'need'], 'required'],
            [['text'], 'string'],
            [['need', 'now', 'publish', 'rank', 'created_at', 'last_donate', 'last_donate_date', 'donate_count', 'sended'], 'integer'],
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
            'text' => 'Текст',
            'need' => 'Нужно собрать',
            'now' => 'Сейчас собрано',
            'publish' => 'Опубликовать',
            'rank' => 'Ранг',
            'created_at' => 'Дата создания',
            'last_donate' => 'Последнее пожертвование',
            'last_donate_date' => 'Дата последнего пожертвования',
            'donate_count' => 'Счетчик',
            'sended' => 'Sended',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonatePays(): \yii\db\ActiveQuery
    {
        return $this->hasMany(DonatePay::className(), ['donate_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return \common\models\query\DonateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DonateQuery(get_called_class());
    }

    /**
     * @throws \Exception
     */
    public function sendNotice(): void
    {
        if ((!$this->sended || $this->sended === 0) && $this->publish){
            $notific = new FirebaseNotifications();

            $title = 'Запущен новый сор пожертвований';
            $body = $this->title;
            $link = '/donate/';

            $notification = [
                "title" => $title,
                "body" => $body,
                "sound" => "default",
                "click_action" => "FCM_PLUGIN_ACTIVITY"
            ];
            $data = [
                "link" => $link
            ];

            if ($notific->sendNotification('/topics/all', $notification, $data)){
                $this->sended = 1;
            };
        }
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Exception
     */
    public function beforeSave($insert)
    {
        if (!$this->created_at){
            $this->created_at = time();
        }

        if (!$this->rank){
            $this->rank = 100;
        }

        $this->sendNotice();

        return parent::beforeSave($insert);
    }
}
