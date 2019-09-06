<?php
namespace Page;

class Messages
{
    public static $defaultSendIds = '20418,20417';
    public static $defaultSendType = 'groups';
    public static $CURL = '/messages';
    public static $NEWURL = '/messages/new';
    public static $msg_ = 'form input[name=msg_name]';
    public static $recepients = 'form input[name=recepient_ids]';
    public static $recep_type = 'form input[name=recepient_type]';
    public static $type = 'form input[name=msg_type]';
    public static $SMSmessage = 'form textarea[name=sms_message]';
    public static $subject_ = 'form input[name=msg_subject]';
    public static $from_ = 'form input[name=msg_from_name]';
    public static $reply_to = 'form input[name=msg_from_email]';
    public static $tmp_type = 'form input[name=msg_email_template]';
    public static $PERSONAL_EMAILmessage = 'form textarea[name=personal_message]';
    public static $PLAIN_EMAILmessage ='form textarea[name=plain_message]';
    public static $send_time = 'form input[name=msg_send_time]';
    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }
    public function sendingSMS($msg_name, $msg, $recps=false, $recps_type = false, $sendTime=false)
    {
        $msg_recp = $recps ? $recps : self::$defaultSendIds;
        $msg_send_type = $recps_type ? $recps_type : self::$defaultSendType;
        $I = $this->tester;
        $I->amOnPage(self::$NEWURL);
        $I->fillField(self::$msg_, $msg_name);
        $I->executeJS('$("'.self::$recepients.'").val("'.$msg_recp.'");');
        $I->executeJS('$("'.self::$recep_type.'").val("'.$msg_send_type.'");');
        $I->executeJS('$("'.self::$type.'").val("sms");');
        $I->executeJS('$("'.self::$SMSmessage.'").val("'.$msg.'");');
        if($sendTime) $I->executeJS('$("'.self::$send_time.'").val("'.$sendTime.'");');
        $I->executeJS('$("form").submit();');
        return $this;
    }
    public function sendingEMAIL($subject, $msg, $from, $reply_, $recps=false, $recps_type = false, $template='personal', $sendTime=false)
    {
        $msg_recp = $recps ? $recps : self::$defaultSendIds;
        $msg_send_type = $recps_type ? $recps_type : self::$defaultSendType;
        $I = $this->tester;
        $I->amOnPage(self::$NEWURL);
        $I->fillField(self::$msg_, $subject);
        $I->executeJS('$("'.self::$recepients.'").val("'.$msg_recp.'");');
        $I->executeJS('$("'.self::$recep_type.'").val("'.$msg_send_type.'");');
        $I->executeJS('$("'.self::$type.'").val("email");');
        $I->executeJS('$("'.self::$subject_.'").val("'.$subject.'");');
        $I->executeJS('$("'.self::$from_.'").val("'.$from.'");');
        $I->executeJS('$("'.self::$reply_to.'").val("'.$reply_.'");');
        $I->executeJS('$("'.self::$tmp_type.'").val("'.$template.'");');
        $I->executeJS('$("'.self::$PERSONAL_EMAILmessage.'").html("'.$msg.'");');
        $I->executeJS('$("'.self::$PLAIN_EMAILmessage.'").html("'.$msg.'");');
        if($sendTime) $I->executeJS('$("'.self::$send_time.'").val("'.$sendTime.'");');
        $I->executeJS('$("form").submit();');
        return $this;
    }
}
