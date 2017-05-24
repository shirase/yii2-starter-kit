<?php
namespace common\plugins\block_type;

use common\models\Block;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

interface BlockTypePlugin
{
    /**
     * @param Block|null $block
     * @return ActiveRecord
     */
    public static function model($block = null);

    /**
     * @param ActiveRecord $model
     * @param Block $block
     */
    public static function link($model, $block);

    /**
     * @param ActiveForm $form
     * @param Block $model
     * @param array $options
     */
    public static function widget($form, $model, $options=[]);
}