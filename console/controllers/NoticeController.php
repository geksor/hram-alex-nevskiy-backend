<?php


namespace console\controllers;


use common\models\CalendarEvents;
use common\models\EventForHome;
use Yii;
use yii\console\Controller;

class NoticeController extends Controller
{

    /**
     * @throws \Exception
     */
    public function actionSend()
    {
        $timestamp = Yii::$app->formatter->asTimestamp('today');

        $eventForHome = EventForHome::find()->active()->andWhere(['sended' => null])->all();
        $calendarEvents = CalendarEvents::find()
            ->active()
            ->andWhere(['<=', 'start_day', $timestamp])->andWhere(['>=', 'stop_day', $timestamp])
            ->andWhere(['sended' => null ])
            ->all();
        $eventFoHomeCount = count($eventForHome);
        $calendarEventsCount = count($calendarEvents);

        if ($eventFoHomeCount === 0 && $calendarEventsCount === 0){
            $this->stdout('nothing to publish' . PHP_EOL);
        }

        if ($eventFoHomeCount > 0){
            foreach ($eventForHome as $event){
                $event->sendNotice();
                $event->save(false);
            }
            $this->stdout("$eventFoHomeCount events for homepage published" . PHP_EOL);
        }

        if ($calendarEventsCount > 0){
            foreach ($calendarEvents as $event){
                $event->sendNotice();
                $event->save(false);
            }
            $this->stdout("$eventFoHomeCount calendar events published" . PHP_EOL);
        }
    }

}