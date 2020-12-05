<?php


namespace console\controllers;


use common\models\CalendarEvents;
use common\models\EventForHome;
use common\models\Tokens;
use common\models\User;
use Yii;
use yii\console\Controller;

class TokensController extends Controller
{

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionClear()
    {
        $timestamp = Yii::$app->formatter->asTimestamp('now');

        $dellCount = Tokens::deleteAll(['<=', 'expired_at', $timestamp]);

        $this->stdout('Deleted records: ' . $dellCount . PHP_EOL);
}

}