<?php


namespace console\controllers;


use common\models\Profile;
use yii\console\Controller;

class ProfileController extends Controller
{

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionStart()
    {
        Profile::updateAll(['all_donate' => 0, 'last_donate' => 0], ['all_donate' => null, 'last_donate' => null]);

        $this->stdout('Done!' . PHP_EOL);
    }

}