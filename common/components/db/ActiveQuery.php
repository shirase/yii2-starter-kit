<?php

namespace common\components\db;

use Aws\Common\Enum\DateFormat;
use yii\helpers\FormatConverter;

/**
 * Class ActiveQuery
 * @package common\components\db
 */
class ActiveQuery extends \yii\db\ActiveQuery {
    use ActiveQueryTrait;
}