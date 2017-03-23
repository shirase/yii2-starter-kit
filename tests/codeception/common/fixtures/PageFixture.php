<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class PageFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Page';
    public $dataFile = '@tests/codeception/common/fixtures/data/page.php';
}