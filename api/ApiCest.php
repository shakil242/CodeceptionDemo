<?php

class ApiCest
{
    public $acces_token;
    public  $contact_id;
    public  $user_id;
    public  $account_id;
    public $group_id;
    public $conv_id;
    public $group_conversation_id;
    public $contact_conversation_id;


    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function getAccessToken(ApiTester $I)
    {
        $I->wantTo('Get Acces Token');
        $post = array();
        $post['username'] = "";
        $post['password'] = "";
        $post_array = http_build_query($post);

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('user', $post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $this->acces_token = $I->grabDataFromResponseByJsonPath('$.token')[0];
        $this->user_id = $I->grabDataFromResponseByJsonPath('$..user[0].user_id')[0];
        $this->account_id = $I->grabDataFromResponseByJsonPath('$..user[0].account_id')[0];
    }


    public function getGroups(ApiTester $I)
    {
        $I->wantTo('Get Groups');

        $I->sendGET('groups?account_id='.$this->account_id.'&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        //$I->grabResponse();
       //37246
         $I->seeResponseJsonMatchesJsonPath('$..[0].group_id');
        $this->group_id = 37246;
    }

    public function createNewContact(ApiTester $I)
    {
        $I->wantTo('Create New Contact');
        $timestamp = date('ymdHi');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->user_id;
        $post['email'] = "tester+test".$timestamp."@test.com"; //guid
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('contact',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
       // $I->seeResponseContainsJson();
        $this->contact_id = $I->grabDataFromResponseByJsonPath('$..contact[0].contact_id')[0];
 }

            public function updateCurrentContact(ApiTester $I)
    {
        $I->wantTo('Update Current Contact');
        $timestamp = date('ymdHi');
        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->account_id;
        $post['email'] = "tester+$timestamp@test.com";
        $post['contact_id'] = $this->contact_id;

        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('contact',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
       $I->grabDataFromResponseByJsonPath('$.contact')[0];
 }

    public function checkGroupConversation(ApiTester $I)
    {
        $I->wantTo('Check Group Conversation state 2');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->account_id;
        $post['group_id'] = $this->group_id; //guid
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('group_conversations',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
        $this->group_conversation_id = $I->grabDataFromResponseByJsonPath('$.conv_id')[0];
    }

    public function getConversationForAccount(ApiTester $I)
    {
        $I->wantTo('Get Conversations for Account');
        $I->sendGET('conversations?account_id='.$this->account_id.'&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$..[0].id');
    }

    public function getConversationForGroup(ApiTester $I)
    {
        $I->wantTo('Get conversation for group');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->account_id;
        $post['group_id'] = $this->group_id; //guid
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('group_conversations',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
        $this->group_conversation_id = $I->grabDataFromResponseByJsonPath('$.conv_id')[0];
    }
    public function unarchiveGroupConversationCopy(ApiTester $I)
    {
        $I->wantTo('Unarchive Group Conversation Copy');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['id'] = $this->group_conversation_id;
        $post['conv_archived'] = 0; //guid
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('conversation',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
        //$I->grabDataFromResponseByJsonPath('$.conv_id')[0];
    }


    public function getConversationForContact(ApiTester $I)
    {
        $I->wantTo('Get conversation for contact');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->account_id;
        $post['contact_id'] = $this->contact_id; //guid
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('contact_conversations',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
        $this->contact_conversation_id = $I->grabDataFromResponseByJsonPath('$.conv_id')[0];
    }
    public function archiveGroupConversation(ApiTester $I)
    {
        $I->wantTo('Archive Group Conversation');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['id'] = $this->group_conversation_id;
        $post['conv_archived'] = 1; //guid

        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('conversation',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
       // $this->contact_conversation_id = $I->grabDataFromResponseByJsonPath('$.conv_id')[0];
    }

    public function createNewMessageContact(ApiTester $I)
    {
        $I->wantTo('Create New Message Contact');
        $timestamp = date('ymdHi');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['conv_id'] = $this->contact_conversation_id; //guid
        $post['msg_type'] = 'sms';
        $post['msg_content'] = "Hey there group $timestamp";
        $post['msg_incoming'] = '0';
        $post['msg_sent'] = '0';

        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('messages',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
        //$I->grabDataFromResponseByJsonPath('$.id')[0];
    }


    public function createNewMessageGroup(ApiTester $I)
    {
        $I->wantTo('Create New Message Group');
        $timestamp = date('ymdHi');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['conv_id'] = $this->group_conversation_id; //guid
        $post['msg_type'] = 'sms';
        $post['msg_content'] = "Hey there group $timestamp";
        $post['msg_incoming'] = '0';
        $post['msg_sent'] = '0';

        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('messages',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        // $I->seeResponseContainsJson();
         //$I->grabDataFromResponseByJsonPath('$.id')[0];
    }

    public function updateNewContact(ApiTester $I)
    {
        $I->wantTo('Update New Contact');
        $timestamp = date('ymdHi');
        $post = array();
        $post['token'] = $this->acces_token;
        $post['account_id'] = $this->account_id;
        $post['email'] = "tester+dd".$timestamp."@test.com";
        $post['id'] = $this->contact_id;

        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('contact',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        //$I->grabDataFromResponseByJsonPath('$.contact')[0];
    }

    public function getContactGroups(ApiTester $I)
    {
        $I->wantTo('Get Contact Groups');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['contact_id'] = $this->contact_id;
     //   $post_array = http_build_query($post);
    //    $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('contact_groups?token='.$this->acces_token.'&contact_id='.$this->contact_id);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

        public function getContactForAccount(ApiTester $I)
    {
        $I->wantTo('Get Contacts for Account');
        $I->sendGET('contacts?account_id='.$this->account_id.'&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
       // $I->seeResponseJsonMatchesJsonPath('$..contact_id');
    }

    public function getInstallation(ApiTester $I)
    {
        $I->wantTo('Get Installation');
        $I->sendGET('installation?account_id='.$this->user_id.'&app_device_type=iphone&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

        public function getSingleContact(ApiTester $I)
    {
        $I->wantTo('Get single contact');
        $I->sendGET('contact?contact_id='.$this->contact_id.'&account_id='.$this->account_id.'&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

        public function addContactToGroup(ApiTester $I)
    {
        $I->wantTo('Add Contact to Group');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['group_id'] = $this->group_id;
        $post['contact_id'] = $this->contact_id;
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('group_contact',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

        public function expoNotification(ApiTester $I)
    {
        $I->wantTo('Manage Expo Push Notification');

        $post = array();
        $post['token'] = $this->acces_token;
        $post['user_id'] =$this->user_id ;
        $post['status'] = "1";
        $post['device_token'] = "234234234";
        $post_array = http_build_query($post);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('manage_expo_push_token',$post_array);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function deleteContacts(ApiTester $I)
    {
        $I->wantTo('Remove Contact from Group');
        $I->sendDELETE('contact?contact_id='.$this->contact_id.'&token='.$this->acces_token);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        // $I->seeResponseJsonMatchesJsonPath('$..message_id');
    }

}
