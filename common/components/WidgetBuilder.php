<?php
namespace common\components;

use yii\base\Widget;

/**
 * Class WidgetBuilder
 */
class WidgetBuilder
{
    protected static $class;
    protected $data;

    public function setData($data) {
        $this->data = $data;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3)=='set') {
            $key = lcfirst(substr($name, 3));
            $this->data[$key] = $arguments[0];
            return $this;
        }
        return null;
    }

    public function begin()
    {
        /** @var Widget $class */
        $class = self::class;
        return $class::begin($this->data);
    }

    public static function end()
    {
        /** @var Widget $class */
        $class = self::class;
        return $class::end();
    }

    public function __toString()
    {
        /** @var Widget $class */
        $class = self::class;
        return $class::widget($this->data);
    }
}