<?php
use \Codeception\Util\Locator;


class GroupsCest
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
     * @group groups
     */
    public function checkLinks(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);

        $I->amOnPage(\Page\Groups::$listURL);
        $I->seeInCurrentUrl('/groups');
        $I->see('New Group');
    }

    // Add Group

   public function checkGroups(AcceptanceTester $I, \Page\Login $loginPage)
    {

        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);

        $I->wantTo('Create A New Group');
        $I->amOnPage(\Page\Groups::$listURL);
        $I->seeInCurrentUrl('/groups');
        $I->see('New Group');
        $I->click(\Page\Groups::$addGroupsLink);
        $I->seeInCurrentUrl(\Page\Groups::$newURL);
        $I->see('Group Name');
        $I->click(\Page\Groups::$groupNameInput);

        $id = date('ymdHi');

        $groupsPage = new \Page\Groups($I);

        // Create New Group
        $groupsPage->addingGroup('Test Group '.$id, 'Group Test for '.$id, 'cikey'.$id, 'hello world');

        // Get Base64 Encoded Group ID
        $I->seeInCurrentUrl(\Page\Groups::$viewURL);
        $link_array = explode('/',$I->executeJS("return location.href"));
        $groupBase64 = end($link_array);

        // Check the Group Details
        $I->wantTo('Check the Group Details');
        $groupsPage->checkGroupDetails($groupBase64, 'Test Group '.$id, 'Group Test for '.$id, 'cikey'.$id, 'hello world');

        // Create Create Automated Messages
        $I->wantTo('Create Automated Workflow Steps');
        $groupsPage->createWorkflowStep($groupBase64, 'step test', 'sms', '', 'Hey this is an sms');
        $groupsPage->createWorkflowStep($groupBase64, 'step test', 'email', 'plain', 'Hey this is a plain email');
        $groupsPage->createWorkflowStep($groupBase64, 'step test', 'email', 'personal', 'Hey this is a plain email');

        $groupsPage->pauseCampaign($groupBase64);
        $groupsPage->resumeCampaign($groupBase64);
        // Clone Group
        $I->wantTo('Clone a Group');
        $groupsPage->cloneGroup($groupBase64);

        // Get Base64 Encoded Group ID
        $I->seeInCurrentUrl(\Page\Groups::$viewURL);
        $link_array = explode('/',$I->executeJS("return location.href"));
        $cloneBase64 = end($link_array);

        // Delete Group
        $groupsPage->removeGroup($groupBase64);
        $groupsPage->removeGroup($cloneBase64);

    }

    // public function searchGroup(AcceptanceTester $I, \Page\Login $loginPage)
    // {
    //     $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
    //     $I->amOnPage(\Page\Groups::$listURL);
    //     $I->seeInCurrentUrl('/groups');
    //     $I->see('New Group');
    //
    //     //Search Group - Full Group name
    //     $I->fillField(['class' => 'search-text'], "1st Time Guest Follow-up");
    //     $I->waitForText('1st Time Guest Follow-up', 20, '#ajax');
    //
    //     //Search Group - Full Group name Partial
    //     $I->fillField(['class' => 'search-text'], "1st Time");
    //     $I->waitForText('1st Time ', 20, '#ajax');
    //
    //     //Search Group - No Search Result
    //     $I->fillField(['class' => 'search-text'], "44444");
    //     $I->wait(20);
    //     $I->dontSee('44444','#ajax');
    // }

    // public function groupDetail(AcceptanceTester $I, \Page\Login $loginPage)
    // {
    //     $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
    //     $I->amOnPage(\Page\Groups::$listURL);
    //     $I->seeInCurrentUrl('/groups');
    //     //click on group
    //     $I->click('1st Time Guest Follow-up');
    //     //Read text from group detail page
    //     $I->see('Back to Groups');
    //     $I->see('Group Overview');
    //     $I->see('Automated Workflows');
    //     $I->see('Message History');
    //     $I->see('Members');
    //
    //     // /// clone group start
    //     // $I->click(".icon-clone");
    //     // $keyword= date('ymdHi');
    //     // $I->fillField(['class' => 'value-keyword'], $keyword);
    //     // $I->wait(20);
    //     // $I->click("Create Group");
    //     // $I->wait(20);
    //     // /// clone group end
    //     //
    //     // /// delete group start-- cancel
    //     // $I->click(".icon-trash");
    //     // $I->see("Are you sure, you'd like to delete this group?");
    //     // $I->click("Nevermind");
    //     //
    //     // //delete group start-- delete
    //     // $I->click(".icon-trash");
    //     // $I->see("Are you sure, you'd like to delete this group?");
    //     // $I->click("Yes, Remove Group");
    //     // /// delete group end
    // }
}
