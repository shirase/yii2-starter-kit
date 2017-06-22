<?php

namespace tests\codeception\frontend\_pages;
use yii\base\Component;

/**
 * Represents loging page
 */
class LoginPage extends Component
{
    /**
     * @var \Codeception\Actor the testing guy object
     */
    protected $actor;

    public function __construct($I)
    {
        $this->actor = $I;
    }

    /**
     * Creates a page instance and sets the test guy to use [[url]].
     * @param \Codeception\Actor $I the test guy instance
     * @param array $params the GET parameters to be used to generate [[url]]
     * @return static the page instance
     */
    public static function openBy($I, $params = [])
    {
        $page = new static($I);
        $I->amOnPage($page->getUrl($params));
        return $page;
    }

    public $route = 'user/sign-in/login';

    /**
     * @param string $identity
     * @param string $password
     */
    public function login($identity, $password)
    {
        $this->actor->fillField('input[name="LoginForm[identity]"]', $identity);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('login-button');
    }
}
