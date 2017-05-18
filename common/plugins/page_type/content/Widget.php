<?php
namespace common\plugins\page_type\content;

use common\components\helpers\TreeHelper;
use common\models\Page;
use kartik\widgets\Select2;
use yii;

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
        echo $this->form->field($model, 'template')->dropDownList(yii\helpers\ArrayHelper::map(PageTemplate::findAll(), 'id', 'name'));
        return ob_get_clean();
    }
} 