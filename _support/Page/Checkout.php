<?php
namespace Page;
class Checkout
{
    public static $URL = '/checkout';
    public static $planName = '#checkout > div.checkout-cart > div > strong';
    public static $productID = 'input[name="products"]';
    public static $discountID = 'input[name="discount"]';
    public static $trialDuration = 'input[name="trialDuration"]';
    public static $AccountName = 'input[name="account_name"]';
    public static $AccountFirstName = 'input[name="account_first_name"]';
    public static $AccountLastName = 'input[name="account_last_name"]';
    public static $AccountEmail = 'input[name="account_email"]';
    public static $AccountMobile = 'input[name="account_mobile"]';
    public static $TokenField = 'input[name="card_token"]';
    public static $AccountAgreement = 'input[name="membership-agreement"]';

    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }


    public function fillStripeElement($stripeIframe)
    {
        $I = $this->tester;
        $I->switchToIFrame($stripeIframe);

        // Credit Card
        $ccNumber = str_split('4242424242424242'); // convert the string to array, see below why
        $expiry = str_split('1120');
        $cvc = str_split('123');
        $zip = str_split('12345');
        $ccLength = count($ccNumber);
        $expiryLength = count($expiry);
        $cvcLength = count($cvc);
        $zipLength = count($zip);

        // since the input ids are dynamic and they don't have a 'name' attribute,
        // I'm using the placeholder attribute which uniquely identifies the field
        $fieldCard   = 'input[placeholder="Card number"]';
        $fieldExpiry = 'input[placeholder="MM / YY"]';
        $fieldCvc    = 'input[placeholder="CVC"]';
        $fieldZip    = 'input[placeholder="ZIP"]';

        // can't use the fillField() method here because it messes up the input value
        // iterate through the arrays containing the characters
        // https://gist.github.com/pszucs/eaaa3ebd9da98ad84996e0e43668702c
        for ( $k = 0; $k < $ccLength; $k++ )
            $I->appendField($fieldCard, $ccNumber[$k]);
        for ( $k = 0; $k < $expiryLength; $k++ )
            $I->appendField($fieldExpiry, $expiry[$k]);
        for ( $k = 0; $k < $cvcLength; $k++ )
            $I->appendField($fieldCvc, $cvc[$k]);
        for ( $k = 0; $k < $zipLength; $k++ )
            $I->appendField($fieldZip, $zip[$k]);

        // switch out of iframe
        $I->switchToWindow();

        return $this;
    }
}
