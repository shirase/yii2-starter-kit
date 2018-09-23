<?php

namespace common\models;

/**
 * Class DynamicModel
 * @package common\models
 */
class DynamicModel extends \yii\base\DynamicModel
{
    public static function instance($formName = null, $labels = [], $attributes = [], $config = [])
    {
        $model = new static($attributes, $config);
        $model->setFormName($formName);
        $model->setAttributeLabels($labels);
        return $model;
    }

    protected $_labels;

    public function setAttributeLabels($labels){
        $this->_labels = $labels;

        foreach ($labels as $attribute => $label) {
            if (!isset($this->{$attribute})) {
                $this->defineAttribute($attribute);
            }
        }

        return $this;
    }

    public function getAttributeLabel($name){
        return $this->_labels[$name] ?? $this->generateAttributeLabel($name);
    }

    protected $_formName;

    public function setFormName($formName)
    {
        $this->_formName = $formName;
        return $this;
    }

    public function formName()
    {
        if (isset($this->_formName)) {
            return $this->_formName;
        }
        return parent::formName();
    }
}