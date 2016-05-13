<?php
namespace common\components\helpers;

class TreeHelper {

    public static function tab($data, $attrId='id', $attrPid='pid', $attrName='name', $tab='--')
    {
        $tree = [];
        $rtree = [];
        foreach($data as $row) {
            $rtree[$row->{$attrId}] = $row->{$attrPid};
            $tree[$row->{$attrPid}][] = [$row->{$attrId}, $row->{$attrName}];
        }

        $options = [];
        foreach($tree as $rows) {
            foreach($rows as $row) {
                $level = -1;
                $i = $row[0];
                while(isset($rtree[$i])) {
                    $level++;
                    $i = $rtree[$i];
                }

                $options[$row[0]] = str_repeat($tab, $level).$row[1];
            }
        }
        return $options;
    }
} 