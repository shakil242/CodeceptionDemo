<?php
class OnboardingCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    public function _after(AcceptanceTester $I)
    {
    }

    // Onboarding - Personalize Your Account
    public function OnboardingPersonalizeYourAccount(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);

        $I->amOnPage(\Page\Onboarding::$URL);
        //  $I->see('Start with these these 6 simple steps on the left.');
        $I->fillField('church_name', 'Text in Church');
        $I->click('Complete Step');
        $I->wait(5);
        $I->see("Next Step");
        $I->click("Next Step");
        if ($I->seePageHasElement("Select Your Phone Number")) {
            $I->see("Your Phone Number");
            $I->click("Next Step");
        }else{
            $I->see("Select Your Country");
            $option = $I->grabTextFrom('select option:nth-child(1)');
            $I->selectOption("select", $option);
            $I->fillField('#area-code', 'Text in Church');
        }
        $I->fillField('check_phone',"5874653247");
        $I->click("Next Step");
        $I->see("Add Additional Info To Profile");
        $I->fillField('contact_first_name',"jake");
        $I->fillField('contact_last_name',"text");
        $I->click("Create Person");
//        $I->click('a[href="#confirmContactable"]');
        $I->see('Communication Permission');
        $I->checkOption('.input-checkbox');
        $I->click('#submitNewContact');
        $I->wait(5);
        $I->see('Send Your First Message');

    }

    // Onboarding - Meet Our Team
//    public function OnboardingMeetOurTeam(AcceptanceTester $I, \Page\Login $loginPage)
//    {
//        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
//
//        $I->amOnPage(\Page\Onboarding::$URL.'/2');
//        $I->see("We've Got Your Back");
//        $I->see("We've built a library of help documents for you to explore, or if you have any questions simply get in touch with a friendly member of our team by emailing support@textinchurch.com");
//    }
//
//    // Onboarding - Seleur Phone Number
//    public function OnboardingSelectYourPhoneNumber(AcceptanceTester $I, \Page\Login $loginPage)
//    {
//        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
//
//        // If user already has a phone number
//        $I->amOnPage(\Page\Onboarding::$URL.'/3');
//
//        try {
//            $I->see('Your Phone Number');
//            $I->see('Below is the phone number your ministry selected to send and receive messages.');
//        } catch (Exception $e) {
//            $I->see('Select Your Phone Number');
//            $I->see('You choose the number that sounds best to you, and we do the work in the background to get everything setup!');
//        }
//    }
//
//    // Onboarding - Create Your First Person
//    public function OnboardingCreateYourFirstPerson(AcceptanceTester $I, \Page\Login $loginPage)
//    {
//        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
//
//        $I->amOnPage(\Page\Onboarding::$URL.'/4');
//        $I->see('Create Your First Person');
//        $I->see("To create a contact, all we need is a phone number or an email. Let's use your personal phone number so you can send yourself a test message in the next step.");
//
//        // try bad Number
//        // if user already has an account, try a Current Number
//        // try a new number
//    }
//
//    // Onboarding - Send Your First Message
//    public function OnboardingSendYourFirstMessage(AcceptanceTester $I, \Page\Login $loginPage)
//    {
//        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
//
//        $I->amOnPage(\Page\Onboarding::$URL.'/5');
//        $I->see("Send Your First Message");
//        $I->see("It takes less than a minute to send you first message!");
//    }
//
//    // Onboarding - Gift Card
//    public function OnboardingGiftCard(AcceptanceTester $I, \Page\Login $loginPage)
//    {
//        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
//
//        $I->amOnPage(\Page\Onboarding::$URL.'/6');
//        $I->see("Win a $100 Gift Card");
//        $I->see("Watch this quick training video. Once complete, we'll enter you in to our monthly raffle for a $100 Amazon Gift Card.");
//    }
}
