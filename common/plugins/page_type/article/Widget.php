<?php
namespace common\plugins\page_type\article;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

class Widget extends \yii\base\Widget {
    /**
     * @var \kartik\form\ActiveForm
     */
    public $form;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    public function run()
    {
        $model = $this->model->dataModel;

        ob_start();
        return ob_get_clean();
    }
} 