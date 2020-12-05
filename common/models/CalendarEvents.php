<?php

namespace common\models;

use backend\firebase\FirebaseNotifications;
use Yii;

/**
 * This is the model class for table "calendar_events".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $start_day
 * @property int $stop_day
 * @property string $color
 * @property int $publish
 * @property int $sended
 *
 * @property string $startDayString
 * @property string $stopDayString
 */
class CalendarEvents extends \yii\db\ActiveRecord
{
    public $startDayString;
    public $stopDayString;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calendar_events';
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->startDayString = Yii::$app->formatter->asDate($this->start_day, 'dd-MM-yyyy');
        $this->stopDayString = Yii::$app->formatter->asDate($this->stop_day, 'dd-MM-yyyy');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'startDayString', 'stopDayString', 'color'], 'required'],
            [['text', 'startDayString', 'stopDayString'], 'string'],
            [['start_day', 'stop_day', 'publish', 'sended'], 'integer'],
            [['title', 'color'], 'string', 'max' => 255],
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
            'start_day' => 'Дата начала',
            'startDayString' => 'Дата начала',
            'stopDayString' => 'Дата окончания',
            'stop_day' => 'Дата окончания',
            'color' => 'Цвет',
            'publish' => 'Опубликовать',
            'sended' => 'Sended',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CalendarEventsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CalendarEventsQuery(get_called_class());
    }

    public function isOneDay()
    {
        return $this->start_day === $this->stop_day;
    }

    /**
     * @throws \Exception
     */
    public function sendNotice()
    {
        if ((!$this->sended || $this->sended === 0) && $this->publish && $this->start_day <= Yii::$app->formatter->asTimestamp('today')){
            $notific = new FirebaseNotifications();


            $notification = [
                "title" => 'Богослужения',
                "body" => $this->title,
                "sound" => "default",
                "click_action" => "FCM_PLUGIN_ACTIVITY"
            ];
            $data = [
                "link" => "/calendar/"
            ];

            if ($notific->sendNotification('/topics/all', $notification, $data)){
                $this->sended = 1;
            };
        }
    }

    /**
     * {@inheritdoc}
     * @param bool $insert
     * @return bool
     * @throws \Exception
     */
    public function beforeSave($insert)
    {

        if ($this->startDayString) {

            $this->start_day =
                is_string($this->startDayString)
                    ? Yii::$app->formatter->asTimestamp($this->startDayString)
                    : $this->start_day;

        } elseif (!$this->start_day) {

            $this->start_day = Yii::$app->formatter->asTimestamp('today');

        }

        if ($this->stopDayString) {

            $this->stop_day =
                is_string($this->stopDayString)
                    ? Yii::$app->formatter->asTimestamp($this->stopDayString)
                    : $this->stop_day;

        } elseif (!$this->stop_day) {

            $this->stop_day = Yii::$app->formatter->asTimestamp('today');

        }

        $this->sendNotice();

        return parent::beforeSave($insert);

    }
}
