<?php
use \Codeception\Util\Locator;

class McintegrationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function MailChimpConnect(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->click('Settings');
        $I->seeInCurrentUrl('/settings');
        $I->click('Integrations');
        $I->seeInCurrentUrl('/settings/integrations');
        $I->see('MailChimp');
        $I->amOnPage('/settings/mailchimp');
        $I->wait(10);
        try {
            // Not connected yet
            $I->see('Connect MailChimp');
            $I->click('Connect MailChimp');
        } catch (Exception $e) {
            // Has Connected
            $I->click('1. Connect');
            $I->see('Disconnect');
            $I->click('Disconnect');
            $I->wait(20);
            $I->click(['id' => 'mc-button']);
            $I->wait(10);
            $I->see('Connect MailChimp');
            $I->click('Connect MailChimp');
        }
        $I->wait(5);
        $I->see('Connect Text In Church - QA to your account');
        // we can use input name or id
        $I->fillField('username','mfarhanahmad');
        $I->fillField('password','Hellofarhan@786');
        $I->click('Log In');
    }
    public function createTicGroups(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->amOnPage('/settings/mailchimp');
        $I->wait(20);
        $I->see('Your MailChimp Lists');
        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');
        $I->uncheckOption('(//input[@class="dt-checkboxes"])[1]');
        //$I->checkOption('.dt-checkboxes'); //select-checkbox , input-checkbox
        //$I->uncheckOption('.dt-checkboxes');
        $I->see('Disconnect');
        $I->seeElement('.toggle-tab.tab-sync.disabled');
        //$I->dontSee('3. Sync');
        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');
        $I->click(['class' => 'update-lists-mc']);

        $I->wait(5);
        $I->click('3. Sync');

        $I->checkOption('#permission-checkbox-two');
        $I->see('Your First Sync');
        $I->click(['id' => 'sync-background-process']);
        //// Disconnect MailChimp inetegration
        $I->click('1. Connect');
        $I->see('Disconnect');
        $I->click('Disconnect');
    }

  /*/  public function MailChimpConnect(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->click('Settings');
        $I->seeInCurrentUrl('/settings');
        $I->click('Integrations');
        $I->seeInCurrentUrl('/settings/integrations');
        $I->see('MailChimp');
        $I->amOnPage('/settings/mailchimp');
        try {
            // Not connected yet
            $I->see('Connect MailChimp');
            $I->click('Connect MailChimp');
        } catch (Exception $e) {
            // Has Connected
            $I->see('Disconnect');
            $I->click('Disconnect');
            $I->wait(10);
            $I->see('Connect MailChimp');
            $I->click('Connect MailChimp');
        }
        $I->wait(5);
        $I->see('Connect Text In Church - QA to your account');
        // we can use input name or id
        $I->fillField('username','mfarhanahmad');
        $I->fillField('password','Hellofarhan@786');
        $I->click('Log In');
    }

    public function createTicGroups(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->amOnPage('/settings/integrations');
        $I->seeInCurrentUrl('/settings/integrations');
        $I->see('Sync Contacts and Lists with your MailChimp Account');
        $I->amOnPage('/settings/mailchimp');
        $I->see('Your MailChimp Lists');
        //$I->uncheckOption('.input-checkbox');
        $I->checkOption('.input-checkbox');

        $I->checkOption('(//input[@class="input-checkbox"])[2]');

        $I->click('Go to Sync');
        $I->checkOption('#permission-checkbox-two');
        $I->see('Your First Sync');
        $I->click(['id' => 'sync-background-process']);
    }
    public function disconnectMc(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->amOnPage('/settings/integrations');
        $I->seeInCurrentUrl('/settings/integrations');
        $I->see('Sync Contacts and Lists with your MailChimp Account');
        $I->amOnPage('/settings/mailchimp');
        $I->click('1. Connect');
        $I->see('Disconnect');
        $I->click('Disconnect');
    } */
}
