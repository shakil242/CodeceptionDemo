<?php
	
	$_SERVER['DOCUMENT_ROOT'] = rtrim($_SERVER['PHP_SELF'],'codecept') . '../../..'; //this may be incorrect depending on how the test is called

	//these variables are needed so conf.php doesn't throw an exception
	$_SERVER['REQUEST_METHOD'] = 'GET';
	$_REQUEST['1'] = 1;
	require_once($_SERVER['DOCUMENT_ROOT'].'/API/1_0/conf.php');


	class ticContactTest extends \Codeception\Test\Unit {

		protected $tester;

		public function testSetAndGet(){
			$contact = new ticContact();
			$this->assertFalse($contact->set('contact_id',100));
			$this->assertEquals($contact->set('contact_id',0),0);
			$this->assertEquals($contact->set('contact_mobile_type','test'),'test');
			$this->assertEquals($contact->get('contact_mobile_type'),'test');

			$this->assertEquals($contact->set('contact_phone','(866) 256-2480'),'8662562480');

			$this->assertEquals($contact->set('contact_email','richard@textinchurch.com'),'richard@textinchurch.com');

			$this->expectException('Exception');
			$contact->set('contact_email','12345');
		}

		public function testGetAsArray(){
			$contact = new ticContact();
			$contact->set('contact_mobile_type','test');
			$contact->set('contact_last_name',"Tim “Sunshine” O’Doyle");
			$arrayversion = $contact->getAsArray();
			$this->assertTrue(is_array($arrayversion));
			$this->assertEquals($arrayversion['contact_mobile_type'], $contact->get('contact_mobile_type'));
			$this->assertEquals($arrayversion['contact_last_name'],"Tim \"Sunshine\" O'Doyle");
		}
	}

?>