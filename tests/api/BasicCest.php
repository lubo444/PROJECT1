<?php

class BasicCest
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
        
        $I->amHttpAuthenticated("admin", "aaaAAA111");
        
        $I->submitForm('#loginForm', [
            'login' => 'admin', 
            'password' => 'aaaAAA111'
        ]);
        
        $I->see('admin', '.navbar');
         // saving snapshot
        $I->saveSessionSnapshot('login');
        
        $I->submitForm('#loginForm', [
            'login' => $name, 
            'password' => $password
        ]);/**/
    }

    public function checkEndpointsWithAuth(ApiTester $I)
    {
        $params = [];
        $params[] = ['method' => 'POST', 'route' => 'companies', 'parameters' => ['title' => 't'], 'responseCode' => 201];

        $a = [1, 2, 3, 4, 5];
        foreach ($params as $param) {
            $token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';

            $I->wantTo('Check endpoints');
            //$I->amHttpAuthenticated("admin", "aaaAAA111");
            $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
            $I->amBearerAuthenticated($token);



            switch ($param['method']) {
                case 'GET':
                    $I->sendGET($param['route']);
                    break;
                case 'POST':
                    $I->sendPOST($param['route'], $param['parameters']);
                    break;
                case 'PUT':
                    $I->sendPUT($param['route'], $param['parameters']);
                    break;
                case 'PATCH':
                    $I->sendPATCH($param['route'], $param['parameters']);
                    break;
                case 'DELETE':
                    $I->sendDELETE($param['route'], $param['parameters']);
                    break;
            }

            $I->seeResponseCodeIs($param['responseCode']);

            $I->deleteHeader('Content-Type');
        }
    }

/* */

    /**
     * @example {"routes":"companies", "response":{"a":"c"} }
     */
    public function checkEndpoints(ApiTester $I, \Codeception\Example $examples)
    {

        $I->wantTo('Check endpoints');
        //$token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
        //$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        //$I->amBearerAuthenticated($token);
        //$I->sendGET('companies');
        //$I->sendGET($examples['routes']['route']);
        //$I->sendPOST($example[0], ['title'=>'tttt']);

        $I->sendGET('api/companies');
        $I->seeResponseCodeIs(200);

        //$I->seeResponseCodeIs($examples['response']);
    }

    //@example( response="200", routes= {"companies", "companies/54/offices"}  )

    /* */
}
