<?php

namespace common\components\db;

/**
 * Class ActiveQueryTrait
 * @package common\components\db
 */
trait ActiveQueryTrait {

    public function andFilterRange($column, $range) {
        if($range) {
            $m = explode(' - ', $range);
            if(sizeof($m)==2) {
                if($m[0] && $m[1]) {
                    $this->andFilterWhere(['OR', ['>=', $column, $m[0]], ['<=', $column, $m[1]]]);
                } elseif($m[0]) {
                    $this->andFilterWhere(['>=', $column, $m[0]]);
                } elseif($m[1]) {
                    $this->andFilterWhere(['<=', $column, $m[1]]);
                }
            } else {
                $this->andFilterWhere([$column=>$range]);
            }
        }

        return $this;
    }

    public function andFilterDateRange($column, $range) {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;
        $db = $modelClass::getDb();

        if($range) {
            $m = explode(' - ', $range);
            if(sizeof($m)==2) {
                if($m[0] && $m[1]) {
                    $this->andFilterWhere(['AND', ['>=', 'DATE('.$db->quoteColumnName($column).')', self::normalizeDate($m[0])], ['<=', 'DATE('.$db->quoteColumnName($column).')', self::normalizeDate($m[1])]]);
                } elseif($m[0]) {
                    $this->andFilterWhere(['>=', 'DATE('.$db->quoteColumnName($column).')', self::normalizeDate($m[0])]);
                } elseif($m[1]) {
                    $this->andFilterWhere(['<=', 'DATE('.$db->quoteColumnName($column).')', self::normalizeDate($m[1])]);
                }
            } else {
                $this->andFilterWhere(['like', 'DATE('.$column.')', $range]);
            }
        }

        return $this;
    }

    private static function normalizeDate($date) {
        $format = (($m=\Yii::$app->getModule('datecontrol')) ? \kartik\datecontrol\Module::parseFormat($m->displaySettings['date'], 'date') : 'Y-m-d');
        return \DateTime::createFromFormat($format, $date)->format('Y-m-d');
    }
} 