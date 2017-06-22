<?php

namespace tests\codeception\backend\_pages;
use yii\base\Component;
use yii\base\InvalidConfigException;

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
     * Returns the URL to this page.
     * The URL will be returned by calling the URL manager of the application
     * with [[route]] and the provided parameters.
     * @param array $params the GET parameters for creating the URL
     * @return string the URL to this page
     * @throws InvalidConfigException if [[route]] is not set or invalid
     */
    public function getUrl($params = [])
    {
        if (is_string($this->route)) {
            $params[0] = $this->route;
            return \Yii::$app->getUrlManager()->createUrl($params);
        } elseif (is_array($this->route) && isset($this->route[0])) {
            return \Yii::$app->getUrlManager()->createUrl(array_merge($this->route, $params));
        } else {
            throw new InvalidConfigException('The "route" property must be set.');
        }
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

    public $route = 'sign-in/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $this->actor->fillField('input[name="LoginForm[username]"]', $username);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('login-button');
    }
}
