<?php


namespace console\controllers;


use common\models\CalendarEvents;
use common\models\EventForHome;
use common\models\User;
use Yii;
use yii\console\Controller;

class UsersController extends Controller
{

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionClear()
    {
        $timestamp = Yii::$app->formatter->asTimestamp('now') - 3600;

        $models = User::find()->where(['status' => User::STATUS_INACTIVE])->andWhere(['<=', 'created_at', $timestamp])->all();

        foreach ($models as $model){
            $model->delete();
        }

        $this->stdout('Deleted records: ' . count($models) . PHP_EOL);
    }

}