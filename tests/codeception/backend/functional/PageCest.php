<?php
namespace tests\codeception\backend\functional;

use common\models\Page;
use common\models\User;
use tests\codeception\backend\FunctionalTester;
use tests\codeception\common\fixtures\RbacAuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;

class PageCest
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

    public function _before(FunctionalTester $I) {
        \Yii::$app->user->login(User::findOne(1));
    }

    public function testIndex(FunctionalTester $I) {
        $model = new Page();
        $model->setAttributes([
            'name' => 'Test 1',
            'pid' => null,
            'language' => 'en-US',
        ], false);
        $model->save();

        $I->amOnPage(['page/index']);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeElement('.page-index');
        $I->see('test-1');

        $model->delete();
    }

    public function testCreate(FunctionalTester $I) {
        $I->amOnPage(['page/create']);
        $I->canSeeResponseCodeIs(200);
        $I->fillField('input[name="Page[name]"]', 'Created');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'created']);
    }

    public function testUpdate(FunctionalTester $I) {
        $model = new Page();
        $model->setAttributes([
            'name' => 'Test 1',
            'pid' => null,
            'language' => 'en-US',
        ], false);
        $model->save();

        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/update', 'id'=>$model->id]);
        $I->fillField('input[name="Page[name]"]', 'Updated');
        $I->submitForm('#page-form', []);
        $I->seeRecord(Page::className(), ['slug'=>'test-1','name'=>'Updated']);

        $model->delete();
    }

    public function testDelete(FunctionalTester $I) {
        $model = new Page();
        $model->setAttributes([
            'name' => 'Test 1',
            'pid' => null,
            'language' => 'en-US',
        ], false);
        $model->save();

        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/index']);
        $I->seeRecord(Page::className(), ['id'=>$model->id]);
        $I->sendAjaxPostRequest(['page/delete', 'id'=>$model->id]);
        $I->dontSeeRecord(Page::className(), ['id'=>$model->id]);

        $model->delete();
    }

    public function testView(FunctionalTester $I) {
        $model = new Page();
        $model->setAttributes([
            'name' => 'Test 1',
            'pid' => null,
            'language' => 'en-US',
        ], false);
        $model->save();

        $model = Page::findOne(['slug'=>'test-1']);
        $I->amOnPage(['page/view', 'id'=>$model->id]);
        $I->canSeeResponseCodeIs(200);

        $model->delete();
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

    public function testMove(FunctionalTester $I) {
        $model = new Page();
        $model->setAttributes([
            'name' => 'Test 2',
            'pid' => 1,
            'language' => 'en-US',
        ], false);
        $model->save();

        $modelTest = Page::findOne(['slug'=>'test-2']);
        $I->amOnPage(['page/tree', 'id'=>1]);
        $I->sendAjaxGetRequest(['page/j-move', 'id'=>$modelTest->id, 'position'=>0, 'parent'=>$modelTest->pid]);
        $I->seeResponseCodeIs(200);
        $I->seeRecord(Page::className(), ['id'=>$modelTest->id, 'pos'=>2]);

        $model->delete();
    }
}