<?php
namespace tests\codeception\backend\acceptance;

use tests\codeception\backend\AcceptanceTester;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\common\fixtures\RbacAuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;

class LoginCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/user.php',
            ],
            'user_profile' => [
                'class' => UserProfileFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/user_profile.php',
            ],
            'rbac_auth_assignment' => [
                'class' => RbacAuthAssignmentFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/rbac_auth_assignment.php',
            ],
        ];
    }

    public function testLogin(AcceptanceTester $I)
    {
        $I->wantTo('ensure login page works');

        $loginPage = LoginPage::openBy($I);

        $I->amGoingTo('submit login form with no data');
        $loginPage->login('', '');
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Password cannot be blank.', '.help-block');

        $I->amGoingTo('try to login with wrong credentials');
        $I->expectTo('see validations errors');
        $loginPage->login('admin', 'wrong');
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.', '.help-block');

        $I->amGoingTo('try to login with correct credentials');
        $loginPage->login('webmaster', 'webmaster');
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see that user is logged');
        $I->seeLink('Logout');

        /** Uncomment if using WebDriver
         * $I->click('Logout (erau)');
         * $I->dontSeeLink('Logout (erau)');
         * $I->seeLink('Login');
         */
    }
}