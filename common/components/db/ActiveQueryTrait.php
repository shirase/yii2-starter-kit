<?php
namespace common\components\db;
use yii\db\ActiveQuery;

/**
 * Class ActiveQueryTrait
 * @package common\components\db
 * @method ActiveQuery andFilterWhere(array $condition)
 * @property $modelClass string
 */
trait ActiveQueryTrait
{
    public function andFilterRange($column, $range) {
        if($range) {
            $range = (string)$range;
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
                if($range[0]==='>') {
                    if($range[1]==='=') {
                        $this->andFilterWhere(['>=', $column, substr($range, 2)]);
                    } elseif ($range[1]==='<') {
                        $this->andFilterWhere(['!=', $column, substr($range, 2)]);
                    } else {
                        $this->andFilterWhere(['>', $column, substr($range, 2)]);
                    }
                } elseif ($range[0]==='<') {
                    if($range[1]==='=') {
                        $this->andFilterWhere(['<=', $column, substr($range, 2)]);
                    } elseif ($range[1]==='>') {
                        $this->andFilterWhere(['!=', $column, substr($range, 2)]);
                    } else {
                        $this->andFilterWhere(['<', $column, substr($range, 2)]);
                    }
                } elseif ($range[0]==='!' && $range[1]==='=') {
                    $this->andFilterWhere(['!=', $column, substr($range, 2)]);
                } else {
                    $this->andFilterWhere([$column=>$range]);
                }
            }
        }

        return $this;
    }

    public function andFilterDateRange($column, $range) {
        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;
        $db = $modelClass::getDb();

        if($range) {
            $range = (string)$range;
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
        /** @var \kartik\datecontrol\Module $datecontrolModule */
        $format = (($datecontrolModule=\Yii::$app->getModule('datecontrol')) ? \kartik\datecontrol\Module::parseFormat($datecontrolModule->displaySettings['date'], 'date') : 'Y-m-d');
        return \DateTime::createFromFormat($format, $date)->format('Y-m-d');
    }
} 