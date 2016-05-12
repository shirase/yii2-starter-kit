<?php
namespace common\plugins\page_view\page;

use common\models\Page;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
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
        echo $this->form->field($model, 'page_id')->widget(Select2::className(), ['data'=>[''=>'-']+ArrayHelper::map(Page::find()->andFilterWhere(['OR', ['!=', 'pid', 0], ['IS', 'pid', new yii\db\Expression('NULL')]])->orderBy('bpath')->all(), 'id', 'name')]);
        echo $this->form->field($model, 'canonical')->dropDownList(['0'=>\Yii::t('common', 'No'), '1'=>\Yii::t('common', 'Yes')]);
        return ob_get_clean();
    }
} 