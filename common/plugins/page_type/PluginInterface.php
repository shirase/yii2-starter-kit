<?php
namespace common\plugins\page_type;

interface PluginInterface
{
    public static function dataModel($pageId);

    public static function widget($form, $model, $options=[]);

    public static function URI($Page);

    public static function route($Page);
} 