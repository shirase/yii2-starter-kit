<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class KeyStorageItemFixture extends ActiveFixture
{
    public $modelClass = 'common\models\KeyStorageItem';

    public function load() {
        $this->resetTable();
        parent::load();
    }
}
