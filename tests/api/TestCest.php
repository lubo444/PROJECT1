<?php


class TestCest
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
    }
    
    /**
     * 
     * @example ["/companies", 200, [201, 404]]
     * @example ["/companies/54/offices", 200]
     * @example ["/companies/54/offices/49/openinghours", 200]
     */
    public function tryToSecondTest(ApiTester $I, \Codeception\Example $example)
    {
        $I->wantTo('This is test of multiple executes');

        $I->sendGET($example[0]);

        $I->seeResponseCodeIs($example[1]);
    }
}
