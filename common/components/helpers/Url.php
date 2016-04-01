<?php

namespace common\components\helpers;

class Url extends \yii\helpers\Url {

    public static function normalizeRoute($route) {
        return parent::normalizeRoute($route);
    }
} 