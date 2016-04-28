<?php
namespace common\plugins\page_view\link;

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
        echo $this->form->field($model, 'link');
        return ob_get_clean();
    }
} 