<?php

class RestCest
{

    public function _before(ApiTester $I)
    {
        
    }

    public function _after(ApiTester $I)
    {
        
    }

    public function tryToTest(ApiTester $I)
    {
        $token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated($token);

        $I->sendPOST('/companies', ['title' => 'codeceptionTest']);
        $I->seeResponseCodeIs(201);

        $I->sendPUT('/companies/54', ['title' => 'Qwerty1']);
        $I->seeResponseCodeIs(200);

        $I->sendPATCH('/companies/54', ['title' => 'Qwerty2']);
        $I->seeResponseCodeIs(200);

        $I->sendDELETE('/companies/59', []);
        $I->seeResponseCodeIs(200);

        $I->sendPUT('/companies/58/undelete', []);
        $I->seeResponseCodeIs(200);

        $I->deleteHeader('Content-Type');

        /*
          $I->amHttpAuthenticated('service_user', '123456');
          $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
          $I->sendPOST('users', ['name' => 'davert', 'email' => 'davert@codeception.com']);
          $I->seeResponseCodeIs(200);
          $I->seeResponseIsJson();
          $I->seeResponseContains('{"result":"ok"}');
          /* */
    }

    public function getRandomOffices(ApiTester $I)
    {
        $I->sendGET('/companies');
        //$I->seeResponseCodeIs(200);
        $companyIds = [];
        $companies = $I->grabDataFromResponseByJsonPath("$")[0];
        foreach ($companies as $company){
            $companyIds[] = $company['idCompany'];
        }
            
        $companiesRandIds = array_rand($companyIds, 2);
        
        $I->sendGET('/companies/'.$companiesRandIds[0].'/offices');
        $offices = $I->grabDataFromResponseByJsonPath("$")[0];
        
        $address = 'no office';
        $officesCount = count($offices);
        if($officesCount > 0){
            $officesRandomIds = rand(0, $officesCount-1);
            var_dump($officesRandomIds);
            $address = $offices[$officesRandomIds]['address'];
        }
        
        $I->comment($address);
        
        $I->sendGET('/companies/'.$companiesRandIds[1].'/offices');
        $offices = $I->grabDataFromResponseByJsonPath("$")[0];
        
        $address = 'no office';
        $officesCount = count($offices);
        if($officesCount > 0){
            $officesRandomIds = rand(0, $officesCount-1);
            var_dump($officesRandomIds);
            $address = $offices[$officesRandomIds]['address'];
        }
        
        $I->comment($address);
        
    }

}