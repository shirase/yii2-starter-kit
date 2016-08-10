<?php
namespace common\components\helpers;

class TreeHelper
{

    public static function tab($data, $attrId = 'id', $attrPid = 'pid', $attrName = 'name', $tab = '--')
    {
        $tree = [];
        $rtree = [];
        foreach ($data as $row) {
            $rtree[$row->{$attrId}] = $row->{$attrPid};
            $tree[$row->{$attrPid}][] = [$row->{$attrId}, $row->{$attrName}];
        }

        $options = [];
        foreach ($tree as $rows) {
            foreach ($rows as $row) {
                $level = -1;
                $i = $row[0];
                while (isset($rtree[$i])) {
                    $level++;
                    $i = $rtree[$i];
                }

                $options[$row[0]] = str_repeat($tab, $level) . $row[1];
            }
        }
        return $options;
    }

    public static function makeTree(array $data)
    {
        $tree = [];
        foreach ($data as $model) {
            $tree[$model->pid][] = $model;
        }

        return $tree;
    }

    public static function menuItems(array &$tree, $pid = null)
    {
        if (!$tree) return [];

        reset($tree);
        if ($pid === null) {
            $pid = key($tree);
        }

        $items = [];
        if (isset($tree[$pid])) {
            foreach ($tree[$pid] as $model) {
                $subItems = self::menuItems($tree, $model->id);
                $items[] = ['label' => $model->name, 'url' => Url::pageUrl($model)] + ($subItems ? ['items' => $subItems] : []);
            }
        }

        return $items;
    }
} 