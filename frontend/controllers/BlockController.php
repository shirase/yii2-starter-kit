<?php
namespace frontend\controllers;

use common\models\Block;
use frontend\actions\UpdateAction;
use yii\web\Controller;

class BlockController extends Controller
{
    public function actions() {
        return [
            'update'=>[
                'class'=>UpdateAction::className(),
                'modelClass'=>Block::className(),
            ]
        ];
    }
}