<?php

class CheckoutCest
{
    public function _before(AcceptanceTester $I)
    {
    }
    // tests

    public function validateCcard(AcceptanceTester $I)
    {
        $I->wantTo("Check credit card and expiration date validation messages");
        $I->amOnPage("/checkout");
        $I->see("Start Your Free 14 Day Trial");
        $I->wait(5);

        $I->switchToIFrame("__privateStripeFrame3");
        $I->fillField('cardnumber', '42424'); //4242424242424242
        $I->switchToIFrame();
        $I->fillField('account_mobile', time());
        $I->see("Your card number is incomplete.");

        $I->switchToIFrame("__privateStripeFrame3");
        $I->fillField('cardnumber', '3223232323232323'); //4242424242424242
        $I->switchToIFrame();
        $I->fillField('account_mobile', time());
        $I->see("Your card number is invalid.");

        $I->switchToIFrame("__privateStripeFrame3");
        $I->fillField('cardnumber', '');
        $I->fillField('cardnumber', '4242424242424242');
        $I->fillField('exp-date', '1217');
        $I->switchToIFrame();
        $I->fillField('account_mobile', time());
        $I->see("Your card's expiration year is in the past.");
    }
    public function checkout(AcceptanceTester $I)
    {
        $I->wantTo("Checkout Process");
        $I->amOnPage("/checkout");
        $I->see("Start Your Free 14 Day Trial");
        /// Set Hidden field values
        $I->executeJS('$("input[name=products]").val("basic_monthly");');
        $I->executeJS('$("input[name=discount]").val(0);');
        $I->executeJS('$("input[name=trialDuration]").val(14);');
        $I->fillField('account_name', 'Test '.time());
        $I->fillField('account_first_name', 'TestFirstName');
        $I->fillField('account_last_name', 'TestLastName');
        $I->fillField('account_email', "muhammad+".time().'@textinchurch.com');
        $I->fillField('account_mobile', time());

        $I->wait(5);
        /// Set Stripe Iframe Values
        $I->switchToIFrame("__privateStripeFrame3");
        $I->fillField('cardnumber', '');
        $I->fillField('cardnumber', '4242424242424242');
        $I->fillField('exp-date', '1220');
        $I->fillField('cvc', '123');
        $I->fillField('postal', '60000');
        $I->switchToIFrame();

        $I->checkOption('#checkout input[type=checkbox]');
        $I->click('Start My FREE Trial');

        $I->wait(2);
        $I->amOnPage("/offer/?i=0");


    }
}
