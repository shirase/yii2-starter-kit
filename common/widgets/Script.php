<?php

namespace common\widgets;

use yii\base\Widget;

class Script extends Widget
{
    public function init() {
        ob_start();
    }

    public function run() {
        $script = ob_get_clean();
        $script = preg_replace('#\<script[^>]*\>(.*)\<\/script\>#is', '$1', $script);
        $this->view->registerJs($script);
    }
}