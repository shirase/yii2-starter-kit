<?php
namespace tests\codeception\frontend\functional;

use tests\codeception\frontend\FunctionalTester;

class LoginCest
{
    public function testLogin(FunctionalTester $I)
    {
        /*$I->wantTo('ensure login page works');

        $loginPage = LoginPage::openBy($I);

        $I->amGoingTo('submit login form with no data');
        $loginPage->login('', '');
        $I->expectTo('see validations errors');
        $I->see('Username or email cannot be blank.', '.help-block');
        $I->see('Password cannot be blank.', '.help-block');

        $I->amGoingTo('try to login with wrong credentials');
        $I->expectTo('see validations errors');
        $loginPage->login('admin', 'wrong');
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.', '.help-block');

        $I->amGoingTo('try to login with correct credentials');
        $loginPage->login('webmaster', 'webmaster');
        $I->expectTo('see that user is logged');
        $I->seeLink('Logout');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');*/
    }
}