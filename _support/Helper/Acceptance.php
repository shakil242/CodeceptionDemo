<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

    function takeScreenshot(){
        $this->getModule('WebDriver')->_saveScreenshot(codecept_output_dir().'screenshot_1.png');
    }

    public function getCurrentUrl()
    {
        return $this->getModule('WebDriver')->_getCurrentUri();
    }

}
