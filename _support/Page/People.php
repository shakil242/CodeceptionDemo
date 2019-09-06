<?php
namespace Page;

class People
{
    public static $listURL = '/people';
    public static $PURL = '/people/new';
    public static $importURL = '/settings/import';
    public static $editURL = '/people/edit/';
    public static $viewURL = '/people/view/';
    public static $addPeopleLink = 'a[href="people/new"]';
    public static $importPeopleButton = 'a[href="/settings/import"]';
    public static $fname = 'form input[name=contact_first_name]';
    public static $lname = 'form input[name=contact_last_name]';
    public static $email = 'form input[name=contact_email]';
    public static $mobile_phone = 'form input[name=contact_mobile]';
    public static $home_phone = 'form input[name=contact_phone]';
    public static $addr = 'form input[name=contact_address1]';
    public static $addr2 = 'form input[name=contact_address2]';
    public static $city = 'form input[name=contact_city]';
    public static $commentsField = 'form textarea[name=contact_comments]';
    public static $emailPermissionCheckbox = 'form input[name=contact_optin_email]';
    public static $smsPermissionCheckbox = 'form input[name=contact_optin_sms]';
    public static $createButton = '#submit-adding-contact';
    public static $saveButton = 'form button[type=submit]';
    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }
    public function addingPerson($firstname, $lastname, $email, $mobile_phone, $home_phone, $addr, $addr2, $city)
    {
        $I = $this->tester;
        $I->amOnPage(self::$PURL);
        $I->executeJS('$("'.self::$fname.'").val("'.$firstname.'");');
        $I->executeJS('$("'.self::$lname.'").val("'.$lastname.'");');
        $I->executeJS('$("'.self::$email.'").val("'.$email.'");');
        $I->executeJS('$("'.self::$mobile_phone.'").val("'.$mobile_phone.'");');
        $I->executeJS('$("'.self::$home_phone.'").val("'.$home_phone.'");');
        $I->executeJS('$("'.self::$addr.'").val("'.$addr.'");');
        $I->executeJS('$("'.self::$addr2.'").val("'.$addr2.'");');
        $I->executeJS('$("'.self::$city.'").val("'.$city.'");');
        $I->executeJS('$("'.self::$createButton.'").click();');
        return $this;
    }

    public function editPerson($personKey, $firstname, $comment)
    {
      $I = $this->tester;
      $I->amOnPage(self::$editURL.$personKey);
      $I->fillField(self::$fname, $firstname);
      $I->fillField(self::$commentsField, $comment);
      $I->executeJS("$('".self::$emailPermissionCheckbox."').prop('checked', true)");
      $I->executeJS("$('".self::$smsPermissionCheckbox."').prop('checked', true)");
      $I->click(self::$saveButton);
      return $this;
    }
}
