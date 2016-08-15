<?php 

$I = new ApiTester($scenario);
$I->wantTo('create aaaaaaaaaa');
//$I->amHttpAuthenticated('service_user', '123456');
//$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');

$I->sendGET('api/companies');

//$I->amOnUrl('http://www.project1.lh/api/companies');

$I->seeResponseContainsJson(["test"=>"sss"]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
//$I->seeResponseIsJson();
//$I->seeResponseContains('{"test":"sss"}');