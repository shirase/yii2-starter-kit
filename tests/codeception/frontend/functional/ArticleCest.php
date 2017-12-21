<?php
namespace tests\codeception\frontend;
use common\models\Article;
use tests\codeception\frontend\FunctionalTester;

class ArticleCest
{
    // tests
    public function testArticlesList(FunctionalTester $I)
    {
        $I->amOnPage(['article/index']);
        $I->seeRecord(Article::class, ['slug' => 'test-article-1']);
    }

    public function testArticleView(FunctionalTester $I)
    {
        $I->amOnPage(['article/index']);
        $I->amOnPage(['article/view', 'slug' => 'test-article-1']);
        $I->seeResponseCodeIs(200);
        $I->canSee('Test Article 1', 'h1');
        $I->canSee('Lorem ipsum');
        $I->canSeeElement("//a[contains(@href,'attachment-download')]");
        $I->amOnPage(['article/view', 'slug' => 'unknown-article']);
        $I->canSee('404');
    }
}