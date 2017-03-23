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
        $I->see('Static page');
    }

    public function testCreate(FunctionalTester $I) {
        $I->amOnPage(['page/create']);
        $I->canSeeResponseCodeIs(200);
        $I->fillField('input[name="Page[name]"]', 'Created');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'created']);
    }

    public function testUpdate(FunctionalTester $I) {
        $I->amOnPage(['page/update', 'id'=>3]);
        $I->fillField('input[name="Page[name]"]', 'Updated');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['name'=>'Updated']);
    }

    public function testDelete(FunctionalTester $I) {
        $I->amOnPage(['page/index']);
        $I->seeRecord(Page::className(), ['id'=>3]);
        $I->sendAjaxPostRequest(['page/delete', 'id'=>3]);
        $I->dontSeeRecord(Page::className(), ['id'=>3]);
    }
}