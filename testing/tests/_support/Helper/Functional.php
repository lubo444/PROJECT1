<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{

    public function seeResponseContains($text)
    {
        $this->assertContains($text, $this->getModule('PhpBrowser')->_getResponseContent(), "response contains");
    }

}
