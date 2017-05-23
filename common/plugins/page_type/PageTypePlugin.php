<?php
namespace common\plugins\page_type;

use common\models\Page;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

interface PageTypePlugin
{
    /**
     * @param Page $page
     * @return ActiveRecord
     */
    public static function model($page = null);

    /**
     * @param ActiveRecord $model
     * @param Page $page
     */
    public static function link($model, $page);

    /**
     * @param ActiveForm $form
     * @param Page $page
     * @param array $options
     * @return mixed
     */
    public static function widget($form, $page, $options=[]);

    /**
     * @param Page $page
     * @return string
     */
    public static function URI($page);

    /**
     * @param Page $page
     * @return string
     */
    public static function route($page);
} 