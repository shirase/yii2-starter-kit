<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class UserProfileFixture extends ActiveFixture
{
    public $modelClass = 'common\models\UserProfile';
    public $depends = [
        'tests\codeception\common\fixtures\UserFixture'
    ];

    public function load() {
        $this->resetTable();
        parent::load();
    }
}
