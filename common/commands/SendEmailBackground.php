<?php

namespace common\commands;

use trntv\bus\interfaces\BackgroundCommand;
use trntv\bus\middlewares\BackgroundCommandTrait;
use yii\base\Object;
use yii\swiftmailer\Message;
use trntv\bus\interfaces\SelfHandlingCommand;

class SendEmailBackground extends SendEmailCommand implements SelfHandlingCommand, BackgroundCommand
{
    use BackgroundCommandTrait;

    public $appPath;

    public function init()
    {
        parent::init();
        $this->appPath = \Yii::getAlias('@app');
    }

    /**
     * @param SendEmailBackground $command
     */
    public function handle($command) {
        \Yii::setAlias('@app', $command->appPath);
        return parent::handle($command);
    }
}
