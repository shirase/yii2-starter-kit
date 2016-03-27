<?php
namespace common\components\db;
use Aws\Common\Enum\DateFormat;

/**
 * Class ActiveQuery
 * @package common\components\db
 */
class ActiveQuery extends \yii\db\ActiveQuery {

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
                $this->andFilterWhere(['like', $column, $range]);
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
                    $this->andFilterWhere(['AND', ['>=', 'DATE('.$db->quoteColumnName($column).')', $m[0]], ['<=', 'DATE('.$db->quoteColumnName($column).')', $m[1]]]);
                } elseif($m[0]) {
                    $this->andFilterWhere(['>=', 'DATE('.$db->quoteColumnName($column).')', $m[0]]);
                } elseif($m[1]) {
                    $this->andFilterWhere(['<=', 'DATE('.$db->quoteColumnName($column).')', $m[1]]);
                }
            } else {
                $this->andFilterWhere(['like', 'DATE('.$column.')', $range]);
            }
        }

        return $this;
    }
}