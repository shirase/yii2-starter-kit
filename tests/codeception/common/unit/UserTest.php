<?php
namespace tests\codeception\common\unit;

use PHPUnit\Framework\TestCase;
use tests\codeception\common\fixtures\RbacAuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;
use Yii;
use Codeception\Specify;

class UserTest extends TestCase
{
    public $appConfig = '@tests/codeception/config/common/unit.php';

    /**
     * @var \tests\codeception\common\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'user' => array(
                'class' => UserFixture::class,
                'dataFile' => '@tests/codeception/common/fixtures/data/user.php',
            ),
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

    protected function _before()
    {

    }


    protected function _after()
    {
    }

    // tests
    public function testUser()
    {
        $user =  new \common\models\User();
        $user->email= "12345677713@test.com";
        $user->password_hash="1234";
        $user->username="<p>xss;</p>";
        $this->assertTrue($user->save());
        $this->assertTrue($user->username==='&lt;p&gt;xss;&lt;/p&gt;');
    }
}