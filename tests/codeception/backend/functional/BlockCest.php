<?php
namespace tests\codeception\backend;

use common\models\Block;
use common\models\Page;
use common\models\User;
use yii\db\Exception;

class BlockCest
{
    public function _before(AcceptanceTester $I) {
        \Yii::$app->user->login(User::findOne(1));
    }

    public function testIndex(FunctionalTester $I) {
        $I->amOnPage(['block/index', 'page_id'=>1]);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeElement('.block-index');
    }

    public function testCreate(FunctionalTester $I) {
        $I->amOnPage(['block/create', 'page_id'=>1]);
        $I->canSeeResponseCodeIs(200);
        $I->fillField('input[name="Block[title]"]', 'Created');
        $I->selectOption('select[name="Block[type_id]"]', '1');
        $I->submitForm('#block-form', []);
        $I->seeRecord(Block::className(), ['title'=>'Created']);
    }

    public function testUpdate(FunctionalTester $I) {
        $model = new Block();
        $model->setAttributes([
            'page_id' => 1,
            'type_id' => 1,
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $I->amOnPage(['block/update', 'id'=>$model->id]);
        $I->fillField('input[name="Block[title]"]', 'Updated');
        $I->submitForm('#block-form', []);
        $I->seeRecord(Block::className(), ['title'=>'Updated']);
    }

    public function testDelete(FunctionalTester $I) {
        $model = new Block();
        $model->setAttributes([
            'page_id' => 1,
            'type_id' => 1,
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $I->amOnPage(['block/index']);
        $I->seeRecord(Block::className(), ['id'=>$model->id]);
        $I->sendAjaxPostRequest(['block/delete', 'id'=>$model->id]);
        $I->dontSeeRecord(Block::className(), ['id'=>$model->id]);
    }

    public function testView(FunctionalTester $I) {
        $model = new Block();
        $model->setAttributes([
            'page_id' => 1,
            'type_id' => 1,
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $I->amOnPage(['block/view', 'id'=>$model->id]);
        $I->canSeeResponseCodeIs(200);
        $I->canSee('Test 1');
    }

    public function testUnexist(FunctionalTester $I) {
        $I->amOnPage(['block/view', 'id'=>'-1']);
        $I->canSeeResponseCodeIs(404);
    }
}