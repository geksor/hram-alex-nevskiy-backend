<?php
namespace api\tests\api;

use api\tests\ApiTester;
use common\fixtures\TokensFixture;
use common\fixtures\UserFixture;

class AuthCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'tokens' => [
                'class' => TokensFixture::className(),
                'dataFile' => codecept_data_dir() . 'tokens.php'
            ],
        ]);
    }

    public function badMethod(ApiTester $I)
    {
        $I->sendGET('/auth');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }

    public function wrongCredentials(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'username' => 'bayer.hudson',
            'password' => 'wrongPassword'
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'password',
            'message' => 'Incorrect username of password.'
        ]);
    }

    public function success(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'username' => 'bayer.hudson',
            'password' => 'password_0'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.token');
        $I->seeResponseJsonMatchesJsonPath('$.expired');
    }
}
