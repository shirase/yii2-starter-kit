<?php
namespace common\plugins\page_view;

interface PluginInterface
{
    public static function dataModel($pageId);

    public static function widget($form, $model, $options=[]);
} 