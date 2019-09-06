<?php
namespace Page;

class Groups
{
    public static $listURL = '/groups';
    public static $newURL = '/groups/new';
    public static $importURL = '/settings/import';
    public static $editURL = '/groups/edit/';
    public static $viewURL = '/groups/view/';
    public static $newStepURL = 'groups/new_auto_message/';
    public static $addGroupsLink = 'a[href="groups/new"]';
    public static $deleteGroupURL = '/groups/delete/';
    public static $cloneGroupURL = '/groups/clone/';
    public static $updateCampaignStatusURL = '/groups/update_campaign_status/';
    public static $groupNameInput = 'input[name=group_name]';
    public static $groupKeyword = 'input[name=group_keyword]';
    public static $groupDescriptionInput = 'input[name=group_comments]';
    public static $groupKeywordToggle = '.keyword-toggle label';
    public static $createButton = 'button[type=submit]';

    public static $newStepName = 'input[name="campaign_step_name"]';
    public static $newStepType = 'input[name="campaign_step_type"]';

    // email only
    public static $newStepEmailFrom = 'input[name=campaign_step_from_name]';
    public static $newStepEmailReply = 'input[name=campaign_step_from_email]';
    public static $newStepEmailSubject = 'input[name=campaign_step_subject]';
    public static $newStepEmailEditor = 'body[id=tinymce]';

    // sms
    public static $newStepSMSMessage = 'textarea[name=sms_message]';

    // step delay
    public static $newStepInterval = 'input[name=campaign_step_interval]';

    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }

    public function addingGroup($groupName, $groupDescription, $groupKeyword, $groupReplyMessage)
    {
        $I = $this->tester;
        $I->amOnPage(self::$newURL);
        $I->executeJS('$("'.self::$groupNameInput.'").val("'.$groupName.'");');
        $I->executeJS('$("'.self::$groupDescriptionInput.'").val("'.$groupDescription.'");');

        // toggle SMS Keyword
        //$I->wantTo('Add a keyword');
       // $I->executeJS('document.getElementById("include_keyword_toggle").checked = true');
       // $I->executeJS('$("'.self::$groupKeyword.'").val("'.$groupKeyword.'");');

        // toggle Form Complete Auto Reply
        $I->wantTo('Create An Auto Reply Message');
        $I->executeJS('document.getElementById("include_reply_toggle").checked = true');
        $I->executeJS('$("#usermsg").html("'.$groupReplyMessage.'");');

        // toggle Form Completion Email Reminder
        $I->wantTo('Create An Auto Reply Email Reminder');
        $I->executeJS('document.getElementById("include_reminder_email_toggle").checked = true');
        $I->executeJS('$("input[name=reminder_to_email]").val("patrick+ci@textinchurch.com");');
        $I->executeJS('$("input[name=reminder_content]").html("'.$groupReplyMessage.'");');

        // toggle Form Completion Text Reminder
        $I->wantTo('Create An Auto Reply Text Reminder');
        $I->executeJS('document.getElementById("include_reminder_sms_toggle").checked = true');
        $I->executeJS('$("input[name=reminder_to_sms]").val("8163639959");');

        $I->executeJS('$("'.self::$createButton.'").click();');
        return $this;
    }

    public function checkGroupDetails($groupBase64, $groupName, $groupDescription, $groupKeyword, $groupReplyMessage)
    {
        $I = $this->tester;
        $I->amOnPage(self::$listURL.'/view/'.$groupBase64);
        $I->see($groupName);

        // toggle SMS Keyword
       // $I->wantTo('Check Group keyword');
      //  $I->seeInField('sms-keyword',$groupKeyword);

        // toggle Form Complete Auto Reply
        $I->wantTo('Check Group Auto Reply Message');
        $I->seeInField('form_completion_sms',$groupReplyMessage);

        // $I->wantTo('Check Group Completion Text Reminder');
        // $I->seeInField('form_completion_reminder_sms', '8163639959');

        $I->wantTo('Check Group Completion Email Reminder');
        $I->seeInField('form_completion_reminder_email', 'patrick+ci@textinchurch.com');

        return $this;
    }

    public function createWorkflowStep($groupBase64, $name, $type, $emailTemplate='personal', $message, $repeat=null)
    {
        $I = $this->tester;
        $I->wantTo('Create a new '.$type.' workflow step');
        $I->amOnPage(\Page\Groups::$newStepURL.$groupBase64);

        // Message Name
        $I->fillField(self::$newStepName, 'Workflow '.$type.' step for '.date('ymdHi'));

        // Message Type
        $I->executeJS('$("#what-kind-to-send").click();');
        $I->executeJS('$("#what-kind-to-send label[data-value=\"'.$type.'\"]").click();');
        $I->executeJS('$("#what-kind-to-send .wizard-submit").click();');

        // Message Creation
        $I->executeJS('$("#what-to-send").click();');
        switch ($type) {
            case "sms":
                // SMS Message Content
                $I->fillField(self::$newStepSMSMessage, $message);
                break;
            case "email":
                // Email Message Content
                $I->fillField(self::$newStepEmailFrom, 'Automated Testing');
                $I->fillField(self::$newStepEmailReply, 'no-reply@textinchurch.com');
                $I->fillField(self::$newStepEmailSubject, 'Automated Email Test');
                $I->executeJS('$(".template-options label[data-value=\"'.$emailTemplate.'\"]").click();');
                if($emailTemplate == 'personal'){
                    $I->switchToIFrame('personal_message_ifr');
                } else {
                    $I->switchToIFrame('plain_message_ifr');
                }
                $I->click('#tinymce');
                $I->fillField('#tinymce', 'Test Content');
                $I->takeScreenshot();
                $I->switchToWindow();
                break;
            case "reminder":
                // Message Content
                $I->executeJS('$("'.self::$newStepSMSMessage.'").val("'.$message.'");');
                break;
            default:
                $I->fillField(self::$newStepSMSMessage, $message);
        }

        $I->executeJS('$("#what-to-send .wizard-submit").click();');

        // When To Send
        $I->executeJS('$("#when-to-send").click();');

        // Submit
        $I->executeJS('$("form").submit();');

        $I->canSeeInCurrentUrl('/groups/auto_messages/'.$groupBase64);

        // $I->see('Your workflow message was created successfully!');

        return $this;
    }

    public function cloneGroup($group) {
        $I = $this->tester;
        $I->wantTo('Clone A Group');
        $I->amOnPage(self::$cloneGroupURL.$group);
        $I->executeJS('$("'.self::$groupKeyword.'").val("ciclone");');
        $I->executeJS('$("'.self::$createButton.'").click();');
        return $this;
    }

    public function removeGroup($group)
    {
        $I = $this->tester;
        $I->wantTo('Delete the '.$group.' group');
        $I->amOnPage(self::$deleteGroupURL.$group);
        return $this;
    }

    public function pauseCampaign($group) {
        $I = $this->tester;
        $I->wantTo('Pause all Campaigns for group');
        $I->amOnPage(self::$viewURL.$group);
        $I->click('a[href="#pauseCampaigns"]');
        $I->see('Yes, Pause Campaign');
        $I->click('Yes, Pause Campaign');
        return $this;
    }
    public function resumeCampaign($group) {
        $I = $this->tester;
        $I->wantTo('Resume all Campaigns for group');
        $I->amOnPage(self::$viewURL.$group);
        $I->click('a span.icon-sync');
        return $this;
    }


}
