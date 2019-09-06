<?php
class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    public function _after(AcceptanceTester $I)
    {
    }
    /**
     * loginLoads
     *
     * @group login
     */
    public function loginLoads(AcceptanceTester $I)
    {
        $I->amOnPage(\Page\Login::$URL);
        $I->see('Login');
        $I->see('Forgot Password');
    }
    /**
     * loginSucceeds
     *
     * @depends loginLoads
     * @group login
     */
    public function loginSucceeds(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        try {
            // User Has Onboarded
            $I->seeInCurrentUrl('/messages');
            $I->seeElement('a[href="/messages/new"]');
            $I->see('Messages');
        } catch (Exception $e) {
            // User Has Not Onboarded
            $I->see('Hey there,');
            $I->see('Start with these these 6 simple steps on the left.');
        }
    }
}
