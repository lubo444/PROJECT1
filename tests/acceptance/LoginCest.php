<?php

class LoginCest
{

    public function _before(AcceptanceTester $I)
    {
        
    }

    public function _after(AcceptanceTester $I)
    {
        
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        //$I->amOnPage('/');
        /*
        $page = $I->openCheckoutFormStep2();
        echo '<pre>';
        var_dump($page);
        echo '</pre>';
        /**/
        //$I->sendGET('api/companies');
        //$I->wantTo('i want login sucessfully');
        //$I->amOnPage('/');
    }

    

    public function checkEndpoints(AcceptanceTester $I)
    {

        $I->wantTo('Check endpoints 23');
        //$token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
        //$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        //$I->amBearerAuthenticated($token);
        //$I->sendGET('companies');
        //$I->sendGET($examples['routes']['route']);
        //$I->sendPOST($example[0], ['title'=>'tttt']);

        //$I->amOnUrl('http://project1.lh');
        $I->amOnPage('company/54');
        $I->seeResponseCodeIs(200);

        //$I->seeResponseCodeIs($examples['response']);
    }
    

}
