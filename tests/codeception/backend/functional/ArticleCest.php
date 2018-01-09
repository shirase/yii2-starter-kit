<?php
namespace tests\codeception\backend;

use common\models\Article;
use common\models\User;
use yii\db\Exception;

class ArticleCest
{
    public function _before(FunctionalTester $I) {
        \Yii::$app->user->login(User::findOne(1));
    }

    public function testIndex(FunctionalTester $I) {
        $I->amOnPage(['article/index']);
        $I->canSeeResponseCodeIs(200);
        $I->canSeeElement('.article-index');
    }

    public function testCreate(FunctionalTester $I) {
        $I->amOnPage(['article/create']);
        $I->canSeeResponseCodeIs(200);
        $I->fillField('input[name="Article[title]"]', 'Created');
        $I->submitForm('#article-form', []);
        $I->seeRecord(Article::className(), ['slug'=>'created']);
    }

    public function testUpdate(FunctionalTester $I) {
        $model = new Article();
        $model->setAttributes([
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $model = Article::findOne(['slug'=>'test-1']);
        $I->amOnPage(['article/update', 'id'=>$model->id]);
        $I->fillField('input[name="Article[title]"]', 'Updated');
        $I->submitForm('#article-form', []);
        $I->seeRecord(Article::className(), ['slug'=>'test-1','title'=>'Updated']);

        $model->delete();
    }

    public function testDelete(FunctionalTester $I) {
        $model = new Article();
        $model->setAttributes([
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $model = Article::findOne(['slug'=>'test-1']);
        $I->amOnPage(['article/index']);
        $I->seeRecord(Article::className(), ['id'=>$model->id]);
        $I->sendAjaxPostRequest(['article/delete', 'id'=>$model->id]);
        $I->dontSeeRecord(Article::className(), ['id'=>$model->id]);

        $model->delete();
    }

    public function testView(FunctionalTester $I) {
        $model = new Article();
        $model->setAttributes([
            'title'=>'Test 1',
        ], false);
        if (!$model->save())
            throw new Exception(var_export($model->errors, true));

        $model = Article::findOne(['slug'=>'test-1']);
        $I->amOnPage(['article/view', 'id'=>$model->id]);
        $I->canSeeResponseCodeIs(200);
        $I->canSee('Test 1');

        $model->delete();
    }

    public function testUnexist(FunctionalTester $I) {
        $I->amOnPage(['article/view', 'id'=>'-1']);
        $I->canSeeResponseCodeIs(404);
    }
}