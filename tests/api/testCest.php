<?php

class testCest
{

    public function _before(ApiTester $I)
    {
        
    }

    public function _after(ApiTester $I)
    {
        
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->wantTo('This is test of one execute');

        $I->sendGET('/companies');

        $I->seeResponseCodeIs(200);
    }

    /**
     * 
     * @example ["/companies", 200]
     * @example ["/companies", 201]
     * @example ["/companies", 200]
     * @example ["/companies", 200]
     */
    public function tryToSecondTest(ApiTester $I, \Codeception\Example $example)
    {
        $I->wantTo('This is test of multiple executes');

        $I->sendGET($example[0]);

        $I->seeResponseCodeIs($example[1]);
    }
    
}
