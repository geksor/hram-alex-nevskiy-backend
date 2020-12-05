<?php

namespace common\models;

use backend\firebase\FirebaseNotifications;
use Yii;

/**
 * This is the model class for table "event_for_home".
 *
 * @property int $id
 * @property int $event_id
 * @property int $event_type
 * @property int $publish_at
 * @property int $publish
 * @property int $sended
 *
 * @property News | Blog $event
 */
class EventForHome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_for_home';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'event_type', 'publish_at'], 'required'],
            [['event_id', 'event_type', 'publish_at', 'publish', 'sended'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'event_type' => 'Event Type',
            'publish_at' => 'Publish At',
            'publish' => 'Publish',
            'sended' => 'Sended',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EventForHomeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\EventForHomeQuery(get_called_class());
    }

    /**
     * @throws \Exception
     */
    public function sendNotice()
    {
        if ((!$this->sended || $this->sended === 0) && $this->publish && $this->publish_at <= Yii::$app->formatter->asTimestamp('today')){
            $notific = new FirebaseNotifications();

            $title = $this->event_type === News::EVENT_TYPE?$this->event->title:"Духовные беседы";
            $body = $this->event_type === News::EVENT_TYPE?$this->event->short_text:$this->event->title;
            $link = $this->event_type === News::EVENT_TYPE?"/news-more/{$this->event->id}/{$this->event->title}":"/video-blog/";

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
        $this->sendNotice();

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        if ($this->event_type === News::EVENT_TYPE){
            return $this->hasOne(News::className(), ['id' => 'event_id']);
        }

        if ($this->event_type === Blog::EVENT_TYPE){
            return $this->hasOne(Blog::className(), ['id' => 'event_id']);
        }

        return null;
    }

    public function fields()
    {
        if ($this->event_type === News::EVENT_TYPE){
            return [
                'id' => 'id',
                'title' => function () {
                    return $this->event->title;
                },
                'publish' => function () {
                    return 'Опубликованно ' . Yii::$app->formatter->asDate($this->publish_at, 'long');
                },
                'text' => function () {
                    return $this->event->short_text;
                },
                'imageLink' => function () {
                    return  Yii::$app->request->hostInfo . $this->event->getThumbImage();
                },
                'eventType' => function () {
                    return 'news';
                },
                'eventId' => function () {
                    return $this->event->id;
                },
            ];
        }
        return [
            'id' => 'id',
            'title' => function () {
                return $this->event->title;
            },
            'publish' => function () {
                return 'Опубликованно ' . Yii::$app->formatter->asDate($this->publish_at, 'long');
            },
            'videoLink' => function () {
                return $this->event->video_link;
            },
            'avatar' => function () {
                if ($abbot = Clergy::getAbbot()){
                    return  Yii::$app->request->hostInfo . $abbot->getPrevImage();
                }
                return Yii::$app->request->hostInfo . '/no_image.png';
            },
            'eventType' => function () {
                return 'talk';
            },
            'eventId' => function () {
                return $this->event->id;
            },
        ];
    }

    public function extraFields()
    {
        return [
            'event' => 'event',
        ];
    }

}
