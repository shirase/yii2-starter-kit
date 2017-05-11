<?php

namespace common\components\web;

/**
 * Class User
 * @package common\components\web
 */
class User extends \yii\web\User {

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if (parent::can('administrator')) {
            return true;
        } else {
            return parent::can($permissionName, $params, $allowCaching);
        }
    }
} 