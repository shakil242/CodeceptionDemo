<?php


class CcbIntegrationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

     public function CcbConnect(AcceptanceTester $I, \Page\Login $loginPage)
   {
    $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
    $I->see('Messages');
    $I->click('Settings');
    $I->seeInCurrentUrl('/settings');
    $I->click('Integrations');
    $I->seeInCurrentUrl('/settings/integrations');
    $I->see('Connect with your Church Community Builder Account.');
    $I->click(['id' => 'ccb-button']);
    try {
        // If connected
        $I->click('1. Connect');
        $I->see('Disconnect');
        $I->click('Disconnect');

        $I->click(['id' => 'ccb-button']);
        $I->wait(2);
       // $I->amOnPage('/settings/church_community_builder');

        $I->fillField('ccb_api_url','multisite.ccbchurch.com');
        $I->fillField('ccb_username','mfarhanahmad');
        $I->fillField('ccb_password','hello@farhan');
        $I->click('Save');

    } catch (Exception $e) {
        // Not connected yet
        $I->fillField('ccb_api_url','multisite.ccbchurch.com');
        $I->fillField('ccb_username','mfarhanahmad');
        $I->fillField('ccb_password','hello@farhan');
        $I->click('Save');
    }
}

    public function createTicGroups(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->amOnPage('/settings/church_community_builder');
        $I->seeInCurrentUrl('/settings/church_community_builder');
        $I->wait(40);

        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');
        $I->uncheckOption('(//input[@class="dt-checkboxes"])[1]');
        $I->see('Disconnect');
        $I->seeElement('.toggle-tab.tab-sync.disabled');
        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');

        $I->click(['class' => 'ccb-sync-now']);
        $I->wait(2);
        $I->checkOption('#permission-checkbox-two');
        $I->see('Your First Sync');
        $I->click(['id' => 'sync-background-process']);

        $I->click('1. Connect');
        $I->see('Disconnect');
        $I->click('Disconnect');
    }



    public function createMessagesBulk(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('People');
        $I->click('a[href="/people"]');
        $I->amOnPage('/people');
        $I->seeInCurrentUrl('/people');
        $I->click('a[href="/people/manage/"]');
        $I->seeInCurrentUrl('/people/manage');
        $I->click("#tableSelectAll");
        $I->wait(5);
        $I->see('Create Message');
        $I->click("Create Message");
        $I->wait(10);
        $I->seeElement('a[href="/messages/new"]');
        $I->amOnPage("/messages/new");

        $I->fillField("form input[name=msg_name]", "Automated Email Test Run");
        $I->executeJS('$("form input[name=msg_type]").val("sms");');
        $I->executeJS('$("form textarea[name=sms_message]").val("Testing Sending an Email for Automated Run")');
        $I->executeJS('$("form").submit();');
    }

}
