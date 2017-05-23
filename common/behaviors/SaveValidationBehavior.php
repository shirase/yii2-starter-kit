<?php
namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\validators\Validator;

class SaveValidationBehavior extends Behavior
{
    const SCENARIO = 'SaveValidationBehavior';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function beforeSave(ModelEvent $event) {
        /** @var Model $model */
        $model = $this->owner;

        if (!$model->hasErrors()) {
            $validators = [];
            $scenario = self::SCENARIO;
            foreach ($model->getValidators() as $validator) {
                if (!empty($validator->on) && in_array($scenario, $validator->on, true)) {
                    $validators[] = $validator;
                }
            }

            foreach ($validators as $validator) {
                /** @var $validator Validator */
                $validator->validateAttributes($model);

                if ($model->hasErrors()) {
                    $event->isValid = false;
                    break;
                }
            }
        }
    }
}