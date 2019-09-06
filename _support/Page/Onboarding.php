<?php
namespace Page;

class Onboarding
{
    public static $URL = '/settings/onboarding';

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
    
}
