<?php

namespace common\web;

/**
 * Class User
 * @package common\web
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