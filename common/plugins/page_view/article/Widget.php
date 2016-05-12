<?php
namespace common\plugins\page_view\article;

use common\models\ArticleCategory;
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
        echo $this->form->field($model, 'category_id')->widget(Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(ArticleCategory::find()->orderBy('id')->all(), 'id', 'title')]);
        return ob_get_clean();
    }
} 