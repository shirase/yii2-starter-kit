<?php
namespace tests\codeception\backend;

use common\models\Page;
use common\models\User;

class PageCest
{
    public function _before(AcceptanceTester $I) {
        \Yii::$app->user->login(User::findOne(1));
        $model = new Page();
        $model->setAttributes([
            'name'=>'Test 1',
            'pid'=>null
        ], false);
        $model->save();
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
        $I->fillField('input[name="Page[name]"]', 'Created');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'created']);
    }

    public function testUpdate(FunctionalTester $I) {
        $model = Page::findOne(['name'=>'Test 1']);
        $I->amOnPage(['page/update', 'id'=>$model->id]);
        $I->fillField('input[name="Page[name]"]', 'Updated');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['name'=>'Updated']);
    }

    public function testDelete(FunctionalTester $I) {
        $model = Page::findOne(['name'=>'Test 1']);
        $I->amOnPage(['page/index']);
        $I->seeRecord(Page::className(), ['id'=>$model->id]);
        $I->sendAjaxPostRequest(['page/delete', 'id'=>$model->id]);
        $I->dontSeeRecord(Page::className(), ['id'=>$model->id]);
    }
}