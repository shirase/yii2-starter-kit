<?php
namespace tests\codeception\frontend\functional;

use tests\codeception\common\fixtures\ArticleAttachmentFixture;
use tests\codeception\common\fixtures\ArticleFixture;
use tests\codeception\common\fixtures\RbacAuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;
use tests\codeception\frontend\FunctionalTester;

class ArticleCest
{
    public function _fixtures()
    {
        return [
            'article' => [
                'class' => ArticleFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/article.php',
            ],
            'article_attachment' => [
                'class' => ArticleAttachmentFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/article_attachment.php',
            ],
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

    // tests
    public function testArticlesList(FunctionalTester $I)
    {
        $I->amOnPage(['article/index']);
        $I->seeResponseCodeIs(200);
        $I->canSee('Articles', 'h1');
        $I->canSee('Test Article 1', 'h2');
        $I->dontSee('Test Article 2', 'h2');
    }

    public function testArticleView(FunctionalTester $I)
    {
        $I->amOnPage(['article/view', 'slug' => 'test-article-1']);
        $I->seeResponseCodeIs(200);
        $I->canSee('Test Article 1', 'h1');
        $I->canSee('Lorem ipsum');
        $I->canSeeElement("//a[contains(@href,'attachment-download')]");
        $I->amOnPage(['article/view', 'slug' => 'unknown-article']);
        $I->canSee('404');
    }
}