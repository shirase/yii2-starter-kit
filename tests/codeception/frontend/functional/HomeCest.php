<?php
namespace tests\codeception\frontend\functional;

use Yii;
use tests\codeception\frontend\FunctionalTester;

class HomeCest
{
    public function testHome(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('Yii2 Starter Kit');
        $I->seeLink('About');
        $I->click('About');
        $I->see('Lorem ipsum');
    }
}