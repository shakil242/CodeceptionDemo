<?php
class MessagesCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    public function _after(AcceptanceTester $I)
    {
    }
    /**
     * first login
     *
     * @group login
     */
    public function login(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->seeInCurrentUrl('/messages');
        $I->seeElement('a[href="/messages/new"]');
        $I->amOnPage(\Page\Messages::$CURL);
        $I->seeElement('a[href="/messages/new"]');
        $this->smsMessage($I);
        $this->emailMessage($I);
    }

    private function emailMessage(AcceptanceTester $I)
    {
        $I->amOnPage(\Page\Messages::$NEWURL);
        $I->see('Create a New Message');
        $converPage = new \Page\Messages($I);
        $converPage->sendingEMAIL('Automated Email Test Run: '.date('Y-m-d h:i:s'), 'Testing Sending an Email for Automated Run at '.date('Y-m-d h:i:s'), 'automatedtest@emails.church', 'Automated Testing');
    }
    private function smsMessage(AcceptanceTester $I)
    {
        $I->amOnPage(\Page\Messages::$NEWURL);
        $I->see('Create a New Message');
        $converPage = new \Page\Messages($I);
        $converPage->sendingSMS('Automated SMS Test Run: '.date('Y-m-d h:i:s'), 'Testing Sending a Text for Automated Run at '.date('Y-m-d h:i:s'));
    }

    public function createSmsMessage(AcceptanceTester $I, \Page\Login $loginPage)
    {

        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->seeInCurrentUrl('/messages');
        $I->wait(5);
        $I->seeElement('a[href="/messages/new"]');
        // $I->amOnPage(\Page\Messages::$CURL);
        $I->wait(5);
        $I->click('a[href="/messages/new"]');
       $I->wait(5);
        $id = date('y-m-d H i');
        $I->fillField("form input[name=msg_name]", "Automated Email Test Run ".$id);
        $I->fillField("form div.filter-list input[class=input-text]","a");
        $I->wait(5);
        $I->click('div.input-select-option');
        $I->click('#who-to-send .button-small');
        $I->wait(5);

        $I->click('#what-kind-to-send');
        $I->click('label[data-value=sms]');
       $I->click('#what-kind-to-send .button-small');
       $I->wait(5);
       $I->click('#what-to-send');
       $I->fillField("form textarea[name=sms_message]", "Hi i am sending test sms  ".$id." ");
       $I->click('div.shortcode-insert button');
        $I->wait(5);
        $I->click('#what-to-send .button-small');
        $I->click('#when-to-send');
        $I->wait(5);

        $I->click('#when-to-send .button-green');
    }
    public function createEmailMessage(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->seeInCurrentUrl('/messages');
        $I->wait(5);
        $I->seeElement('a[href="/messages/new"]');
        // $I->amOnPage(\Page\Messages::$CURL);
        $I->wait(5);
        $I->click('a[href="/messages/new"]');
        $I->wait(5);
        $id = date('y-m-d H i');
        $I->fillField("form input[name=msg_name]", "Automated Email Test Run ".$id);
        $I->wait(5);
        $I->fillField("form div.filter-list input[class=input-text]","a");
        $I->wait(5);
        $I->click('div.input-select-option');
        $I->click('#who-to-send .button-small');
        $I->click('#what-kind-to-send');
        $I->click('label[data-value=email]');
        $I->click('#what-kind-to-send .button-small');
        $I->click('#what-to-send');
        $I->wait(5);
        $I->fillField("form input[name=msg_from_name]", "Jake testing message");
        $I->fillField("form input[name=msg_from_email]", "jake@techinchurch.com");
        $I->fillField("form input[name=msg_subject]", "Test subject");
        $I->wait(5);
        $I->fillTinyMceEditorByName('personal_message', 'Auto test email message');
        $I->wait(5);
        $I->click('#what-to-send .button-small');
        $I->click('#when-to-send');
        $I->click('#when-to-send .button-green');
    }

}
