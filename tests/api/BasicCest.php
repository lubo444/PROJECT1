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
        
    }

    /*
      public function checkEndpointsWithAuth(ApiTester $I)
      {
      $params = [];
      $params[] = ['method'=>'GET', 'route'=>'companies', 'parameters'=>['title'=>'t'], 'responseCode'=>200];
      $params[] = ['method'=>'GET', 'route'=>'companies', 'parameters'=>['title'=>'t'], 'responseCode'=>200];
      $params[] = ['method'=>'GET', 'route'=>'companies', 'parameters'=>['title'=>'t'], 'responseCode'=>201];
      $params[] = ['method'=>'GET', 'route'=>'companies', 'parameters'=>['title'=>'t'], 'responseCode'=>200];
      $params[] = ['method'=>'GET', 'route'=>'companies', 'parameters'=>['title'=>'t'], 'responseCode'=>200];

      $a = [1, 2, 3, 4, 5];
      foreach ($params as $param) {
      $token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';

      $I->wantTo('Check endpoints');
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
      }/* */

    /**
     * @example {"routes":"companies", "response":{"a":"c"} }
     */
    public function checkEndpoints(ApiTester $I, \Codeception\Example $examples)
    {

        $I->wantTo('Check endpoints');
        //$token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
        //$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        //$I->amBearerAuthenticated($token);
        $I->sendGET('companies');
        //$I->sendGET($examples['routes']['route']);
        //$I->sendPOST($example[0], ['title'=>'tttt']);
        echo '<pre>';
        dump($examples);
        echo '</pre>';
        die;
        $I->seeResponseCodeIs($examples['response']);
    }
    //@example( response="200", routes= {"companies", "companies/54/offices"}  )

    /* */
}
