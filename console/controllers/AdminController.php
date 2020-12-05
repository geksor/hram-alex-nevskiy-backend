<?php
namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;


class AdminController extends Controller
{
    /**
     * @param $password
     * @throws \Exception
     */
    public function actionCreate($password)
    {
        if ($password){
            $user = new User();
            $user->status = $user::STATUS_ACTIVE;
            $user->username = 'admin';
            $user->email = 'admin@example.ru';
            $user->setPassword($password);
            $user->generateAuthKey();

            if ($user->save()){
                $auth = Yii::$app->authManager;
                $auth->assign($auth->getRole('admin'), $user->id);
                $this->stdout('success' . PHP_EOL);
            }else{
                $this->stdout('save error' . PHP_EOL);
            }
        }else{
            $this->stdout('need enter password' . PHP_EOL);
        }
    }

    /**
     * @throws \Exception
     */
    public function actionSetRole()
    {
        $user = User::find()->where(['username' => 'admin'])->one();

        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole('admin'), $user->id);

        $this->stdout('success' . PHP_EOL);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function actionPassword($password)
    {
        if ($password){
            $user = User::find()->where(['username' => 'admin'])->one();
            $user->setPassword($password);
            $user->generateAuthKey();

            if ($user->save()){
                $this->stdout('success' . PHP_EOL);
            }else{
                $this->stdout('save error' . PHP_EOL);
            }
        }else{
            $this->stdout('need enter password' . PHP_EOL);
        }
    }
}