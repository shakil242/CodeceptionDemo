<?php
use \Codeception\Util\Locator;


class PeopleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /* Tests
     */

    /**
     * checkLinks
     *
     * @group people
     */
    public function checkPeopleCreate(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $id = date('ymdHi');
        $rand=rand(1,9);

        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->click('a[href="/people"]');
        $I->seeInCurrentUrl('/people');
        $I->see('New Person');
        $I->see('Import People');
        $I->click('New Person');
        $I->see('Create New Person');
        $I->fillField('check_email', 'shakilldss@textinchurch.com');
        $I->click('a[href="#syncingSocial"]');
        $I->wait('5');
        $I->see('Add Additional Info To Profile');
        $I->seeInCurrentUrl('/people/new');
        $I->fillField('contact_first_name', 'shakeel');
        $I->fillField('contact_last_name', 'shaki');
        $I->fillField('contact_phone', '554454268');
        $I->fillField('contact_address1', 'test');
        $I->fillField('contact_address2', 'test 2');
        $I->fillField('contact_city', 'New york');
        $I->fillField('contact_zip', '503');
        $I->fillField('contact_facebook_url', 'www.facebook.com');
        $I->fillField('contact_comments', 'My happy test comments');
        $I->click('a[href="#confirmContactable"]');
        $I->see('Communication Permission');
        $I->click('#submit-adding-contact');
    }


    public function checkLinks(AcceptanceTester $I, \Page\Login $loginPage)
    {

        $I->amOnPage(\Page\People::$listURL);

        try {
            $I->see('People');
        } catch (Exception $e) {
            $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        }
        $I->amOnPage(\Page\People::$listURL);

        $I->seeInCurrentUrl('/people');

        $I->see('New Person');
        $I->click(\Page\People::$addPeopleLink);
        $I->seeInCurrentUrl(\Page\People::$PURL);
        $I->see('Create New Person');
        $I->see('To get started creating your new person, enter an email or phone number.');
        $I->amOnPage(\Page\People::$listURL);

        $I->see('Import People');
        $I->click(\Page\People::$importPeopleButton);
        $I->seeInCurrentUrl(\Page\People::$importURL);
        $I->see('How To Upload A CSV');
        $I->see('Process File');
    }

    /**
     * checkAddPerson
     *
     * @group people
     */
    public function checkEditPerson(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->amOnPage(\Page\People::$listURL);

        $I->click("#ajax li a");
        $I->seeInCurrentUrl(\Page\People::$viewURL);

        $link_array = explode('/',$I->executeJS("return location.href"));
        $personKey = end($link_array);

        $id = date('ymdHi');

        $peoplePage = new \Page\People($I);
        $peoplePage->editPerson($personKey, 'Automated-'.$id, $id);

        $I->seeCurrentUrlEquals(\Page\People::$viewURL.$personKey);
        $I->amOnPage(\Page\People::$editURL.$personKey);
        $I->seeInField(\Page\People::$fname, 'Automated-'.$id);
    }

    /**
     * checkAddPerson
     *
     * @group people
     */
     public function checkAddPerson(AcceptanceTester $I, \Page\Login $loginPage)
     {
       $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
       $id = date('ymdHi');
       $converPage = new \Page\People($I);
       $converPage->addingPerson('Create-'.$id, 'Tester', 'creator-'.$id.'@emails.church', '999'.rand(0000000, 9999999), '', '', '', '');
     }

     // T1.38 Import people - Upload CSV
     // 'CSV Import' page opens up on clicking 'CSV IMPORT' button.

     public function viewUploadCSV(AcceptanceTester $I, \Page\Login $loginPage) {
         $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);

         $I->amOnPage('/settings');
         $I->seeInCurrentUrl('/settings');
         $I->click('a[href="/settings/import"]');
         $I->seeInCurrentUrl('/settings/import');
     }



     // T1.39 People Import people - Download CSV Template
     // CSV template gets downloaded after clicking on 'Download CSV Template' link.
     public function downloadCSVTemplate(AcceptanceTester $I) {
         $I->wantTo('Download the CSV Template');
         $I->click('a[href="/downloads/Import-Template.csv"]');
     }



    // T1.40 People Import people - Upload CSV
     // Add Single people with valid field single people get added by importing them with a CSV file.
      public function uploadCSV_addSinglePerson(AcceptanceTester $I) {

          $I->wantTo('Upload a csv with one person');
          $I->attachFile('input[type="file"]', 'single-person-import.csv');
          // this could be used to select a group
          // CSV Import Group ID
          $csvImportGroup = 'NDU5NjM';
          $I->scrollTo('.csv-importer');
          $I->executeJS('$("#group_ids").val("NDg2MTc");');
          $I->checkOption('#csvPermissions');
          $I->click('#csvUploadButton');
          $I->checkOption('#has-header');
          $I->click('#import_people');
      }
     //
     // // T1.41 People Import people - Upload CSV - Add Multiple people with valid field
     // // Multiple people get added by importing them with a CSV file.
     // public function uploadCSV_addMultPeople(AcceptanceTester $I) {
     //
     //     $I->wantTo('Upload a csv with mutlipe people');
     //     $I->attachFile('input[type="file"]', 'multi-person-import.csv');
     //
     //     // this could be used to select a group
     //     // CSV Import Group ID
     //     $csvImportGroup = '39259';
     //     $I->scrollTo('.csv-importer');
     //     $I->click(['xpath' => '//*[@id="select_file"]/div[2]/fieldset']);
     //     $I->click('.input-select-option[data-value="'.$csvImportGroup.'"]');
     //     $I->checkOption('#csvPermissions');
     //     $I->click('#csvUploadButton');
     //     $I->checkOption('#has-header');
     //     $I->click('#import_people');
     //     // $I->waitForElement('#agree_button', 30); // secs
     //
     // }
     // // T1.42 People CSV Import - Add single people to the group
     // // 1. Single people get added to the group by importing them with a CSV file.
     // // 2. Imported people appears under 'Members' page of selected group.
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
     // // T1.43 People CSV Import - Add Multiple people to the group.
     // // 1. Multiple people get added to the group by importing them with a CSV file.
     // // 2. Imported people appears under 'Members' page of selected group."
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
     // // T1.44 People Import people - Upload CSV - Duplicate email id.
     // // People get added with duplicate email id.
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
     // // T1.45 People Import people - Upload CSV - Duplicate phone number.
     // // People get added with duplicate phone number.
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
     // // T1.46 People Import people - Upload CSV - Invalid email id.
     // // People get added with invalid email id.
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
     // // T1.47 People Import people - Upload CSV - Invalid phone number.
     // // People get added with invalid phone number.
     // public function uploadCSV(AcceptanceTester $I) {
     //
     // }
}
