<?php
namespace Page;

class Login
{
    public static $URL = '/signin';
    public static $defaultUsername = 'autotest@textinchurch.com';
    public static $defaultPassword = '12345';
    public static $forgotLink = 'form a[href="/forgotPassword"]';
    public static $loginButton = 'form button[type=submit]';
    public static $usernameField = 'form input[name=username]';
    public static $passwordField = 'form input[name=password]';
    protected static $session = false;
    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }
    public function login($username='', $password='', $useSnapshot=true)
    {
        $I = $this->tester;
        $I->amOnPage(self::$URL);
        $I->fillField(self::$usernameField, $username);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$loginButton);
    }
}
