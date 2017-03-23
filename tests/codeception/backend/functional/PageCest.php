<?php
namespace tests\codeception\backend;

use common\models\Page;
use common\models\User;

class PageCest
{
    public function _before(AcceptanceTester $I) {
        \Yii::$app->user->login(User::findOne(1));
    }

    public function testIndex(FunctionalTester $I) {
        $I->amOnPage(['page/index']);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeElement('.page-index');
        $I->see('test-1');
    }

    public function testCreate(FunctionalTester $I) {
        $I->amOnPage(['page/create']);
        $I->canSeeResponseCodeIs(200);
        $I->fillField('input[name="Page[name]"]', 'Test 2');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'test-2']);

        $I->amOnPage(['page/index']);
        $I->see('Test 2');
    }

    public function testUpdate(FunctionalTester $I) {
        $I->amOnPage(['page/update', 'id'=>2]);
        $I->fillField('input[name="Page[name]"]', 'Test 3');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['name'=>'Test 3']);
    }

    public function testDelete(FunctionalTester $I) {
        $I->amOnPage(['page/index']);
        $I->seeRecord(Page::className(), ['id'=>2]);
        $I->sendAjaxPostRequest(['page/delete', 'id'=>2]);
        $I->dontSeeRecord(Page::className(), ['id'=>2]);
    }
}