<?php

namespace common\validators;

use yii\db\ActiveRecord;

class DateValidator extends \yii\validators\DateValidator
{
    private $handlered = [];

    public $format = 'php:d.m.Y';

    public function validateAttribute($model, $attribute) {
        $value = $model->{$attribute};
        if (!$value || !is_string($value) || \DateTime::createFromFormat('Y-m-d H:i:s', $value) || \DateTime::createFromFormat('Y-m-d', $value)) return;

        parent::validateAttribute($model, $attribute);

        if (!$model->hasErrors($attribute)) {
            if ($ts = $this->parseDateValue($model->$attribute)) {
                if (array_search($attribute, $this->handlered)===false) {
                    $this->handlered[] = $attribute;
                    DateValidatorHandler::init($model, $attribute, date('Y-m-d H:i:s', $ts));
                }
            }
        }
    }
}

class DateValidatorHandler {

    /**
     * @var ActiveRecord
     */
    public $model;
    public $attribute;
    public $value;
    private $old;

    public static function init($model, $attribute, $value) {
        $handler = new self();

        $handler->model = $model;
        $handler->attribute = $attribute;
        $handler->value = $value;

        $handler->model->on(ActiveRecord::EVENT_BEFORE_INSERT, array($handler, 'beforeSave'));
        $handler->model->on(ActiveRecord::EVENT_BEFORE_UPDATE, array($handler, 'beforeSave'));
        $handler->model->on(ActiveRecord::EVENT_AFTER_INSERT, array($handler, 'afterSave'));
        $handler->model->on(ActiveRecord::EVENT_AFTER_UPDATE, array($handler, 'afterSave'));
    }

    public function beforeSave($event) {
        if($this->model && !$this->model->hasErrors()) {
            $this->old = $this->model->{$this->attribute};
            $this->model->{$this->attribute} = $this->value;
        }
    }

    public function afterSave($event) {
        if($this->model && isset($this->old)) {
            $this->model->{$this->attribute} = $this->old;
        }

        unset($this->model);
    }
}