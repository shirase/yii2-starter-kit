<?php
namespace frontend\widgets;

use yii\base\Widget;

class ContentBlock extends Widget
{
    public $model;

    public function run() {
        return $this->render('content-block', ['model'=>$this->model]);
    }
}