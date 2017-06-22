<?php

namespace tests\codeception\frontend\_pages;

use yii\base\Component;

/**
 * Represents signup page
 */
class SignupPage extends Component
{
    /**
     * @var \Codeception\Actor the testing guy object
     */
    protected $actor;

    public function __construct($I)
    {
        $this->actor = $I;
    }

    public $route = '/user/sign-in/signup';

    /**
     * @param array $signupData
     */
    public function submit(array $signupData)
    {
        foreach ($signupData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="SignupForm[' . $field . ']"]', $value);
        }
        $this->actor->click('signup-button');
    }
}
