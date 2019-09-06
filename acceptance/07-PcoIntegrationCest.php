<?php


class PcoIntegrationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function PcoConnect(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->click('Settings');
        $I->seeInCurrentUrl('/settings');
        $I->click('Integrations');
        $I->seeInCurrentUrl('/settings/integrations');
        $I->see('Connect with your Planning Center Account.');
        $I->amOnPage('/settings/pco_integration');
        $I->wait(5);



        try {
            // Not connected yet integration-connect
            $I->click('1. Connect');
            $I->see('Connect Planning Center');
            $I->click(['id' => 'integration-connect']);

            // $I->click(['id' => 'integration-connect']);
            $I->wait(5);
            $I->see("Let's get you logged in");
            $I->fillField('email','muhammad+786@textinchurch.com');
            $I->fillField('password','123456');
            $I->click('Go');

        } catch (Exception $e) {

            try {

                // Has Connected
                $I->see('Disconnect');
                $I->click('Disconnect');
                $I->wait(5);

                $I->click(['id' => 'pco-button']);
                $I->click('1. Connect');
                // $I->click('Connect Planning Center');

                $I->click(['id' => 'integration-connect']);
                $I->wait(5);
                $I->see("Let's get you logged in");
                $I->fillField('email','muhammad+786@textinchurch.com');
                $I->fillField('password','123456');
                $I->click('Go');

            } catch (Exception $e)
            {
                // if token expired for refresh inetegration
                $I->reloadPage();
                $I->wait(5);
                //$I->click('1. Connect');
                $I->click(['id' => 'connect-pco']);
                $I->wait(5);
                $I->see("Let's get you logged in");
                $I->fillField('email','muhammad+786@textinchurch.com');
                $I->fillField('password','123456');
                $I->click('Go');

            }


        }
    }

    public function createTicGroups(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->see('Messages');
        $I->amOnPage('/settings/pco_integration');
        $I->wait(10);
        $I->see('Select Lists that you want to sync with Text In Church.');
        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');
        $I->uncheckOption('(//input[@class="dt-checkboxes"])[1]');
        $I->see('Disconnect');
        $I->seeElement('.toggle-tab.tab-sync.disabled');
        $I->checkOption('(//input[@class="dt-checkboxes"])[1]');
        //$I->checkOption('.select-checkbox');  //select-checkbox , input-checkbox
        //$I->checkOption('(//input[@class="input-checkbox"])[2]');
        //$I->click('Go to Sync');
        $I->click(['class' => 'update-lists']);
        $I->wait(5);
        $I->click('3. Sync');
        $I->checkOption("#permission-checkbox-two");
        $I->see('Your First Sync');
        $I->click(['id' => 'sync-background-process']);
        $I->wait(5);
        //// Disconnect PCO inetegration
        $I->click('1. Connect');
        $I->see('Disconnect');
        $I->click('Disconnect');
    }
}
