<?php

namespace console\controllers;

use common\models\Profile;
use common\models\User;
use common\rbac\Rbac;
use common\rbac\rules\ProfileOwnerRule;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $rule = new ProfileOwnerRule();
        $auth->add($rule);

        $manageProfile = $auth->createPermission(Rbac::MANAGE_PROFILE);
        $auth->add($manageProfile);

        $manageOwnerProfile = $auth->createPermission(Rbac::MANAGE_OWNER_PROFILE);
        $manageOwnerProfile->ruleName = $rule->name;
        $auth->add($manageOwnerProfile);
        $auth->addChild($manageOwnerProfile, $manageProfile);


        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $manageOwnerProfile);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $manageProfile);

        $this->stdout('Done!' . PHP_EOL);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function actionTest()
    {
        Yii::$app->set('request', new \yii\web\Request(['cookieValidationKey' => 'test']));
        Yii::$app->set('response', new \yii\web\Response());

        // ###############################################################################

        $auth = Yii::$app->authManager;

        $user = new User(['id' => 10, 'username' => 'User']);
        $admin = new User(['id' => 20, 'username' => 'Admin']);

        $auth->revokeAll($user->id);
        $auth->revokeAll($admin->id);

//        $auth->assign($auth->getRole('user'), $user->id);
        $auth->assign($auth->getRole('admin'), $admin->id);

        // ##############################################################################

        $this->stdout("Check access fo user {$user->username}\n\n", Console::FG_BLUE);
        Yii::$app->user->login($user);

        $profile = new Profile([
            'user_id' => $user->id,
            'name' => $user->username,
        ]);

        $this->show('Menage profile', Yii::$app->user->can(Rbac::MANAGE_PROFILE, ['profile' => $profile]));
        $this->show('Menage owner profile', Yii::$app->user->can(Rbac::MANAGE_OWNER_PROFILE, ['profile' => $profile]));

        // ###############################################################################

        $this->stdout("Check access fo user {$admin->username}\n\n", Console::FG_BLUE);
        Yii::$app->user->login($admin);

        $this->show('Menage profile', Yii::$app->user->can(Rbac::MANAGE_PROFILE, ['profile' => $profile]));
        $this->show('Menage owner profile', Yii::$app->user->can(Rbac::MANAGE_OWNER_PROFILE, ['profile' => $profile]));

        // ##############################################################################
        $auth->removeAll();
        Yii::$app->set('response', new \yii\console\Response());

    }

    private function show($message, $value)
    {
        $result = $value ? 'true' : 'false';
        $this->stdout("$message: $result\n\n", Console::FG_RED);
    }
}