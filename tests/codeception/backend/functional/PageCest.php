<?php
namespace tests\codeception\backend;

use common\models\Page;
use common\models\User;
use yii\base\Exception;

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

        $model = new Page();
        $model->setAttributes([
            'name'=>'Test 2',
            'pid'=>1
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
        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/update', 'id'=>$model->id]);
        $I->fillField('input[name="Page[name]"]', 'Updated');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'test-1','name'=>'Updated']);
    }

    public function testDelete(FunctionalTester $I) {
        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/index']);
        $I->seeRecord(Page::className(), ['id'=>$model->id]);
        $I->sendAjaxPostRequest(['page/delete', 'id'=>$model->id]);
        $I->dontSeeRecord(Page::className(), ['id'=>$model->id]);
    }

    public function testView(FunctionalTester $I) {
        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/view', 'id'=>$model->id]);
        $I->canSeeResponseCodeIs(200);
    }

    public function testMenu(FunctionalTester $I) {
        $I->amOnPage(['page/menu']);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeElement('.page-index');
        $I->see('main-menu');
    }

    public function testForm(FunctionalTester $I) {
        $I->amOnPage(['page/form']);
        $I->canSeeResponseCodeIs(200);
    }

    public function testTree(FunctionalTester $I) {
        $I->amOnPage(['page/tree', 'id'=>1]);
        $I->canSeeResponseCodeIs(200);
    }

    /*public function testMove(FunctionalTester $I) {
        $modelTest = Page::findOne(['slug'=>'test-2']);
        $I->amOnPage(['page/tree', 'id'=>1]);
        $I->seeRecord(Page::className(), ['id'=>$modelTest->id, 'pos'=>5]);
        $I->sendAjaxGetRequest(['page/j-move', 'id'=>$modelTest->id, 'position'=>0, 'parent'=>$modelTest->pid]);
        $I->seeRecord(Page::className(), ['id'=>$modelTest->id, 'pos'=>2]);
    }*/
}