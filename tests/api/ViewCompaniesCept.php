<?php 
$I = new ApiTester($scenario);

/*
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->haveHttpHeader('cache-control', 'no-cache');
$I->haveHttpHeader('postman-token', 'cd2e508e-2b20-55e0-190b-350eed7ab1d4');
/***/

/*
$I->wantTo('want seeing comany list via API');
$I->sendGET('companies', []);
$I->seeResponseCodeIs(200);
/**/


//codecept_debug('test 1');


/////// TEST REST API ///////////
/*
$I->sendGET('companies/54/offices', []);
$I->seeResponseCodeIs(200);

$token = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->amBearerAuthenticated($token);

$I->sendPOST('companies' ,['title' => 'codeceptionTest']);
$I->seeResponseCodeIs(201);

$I->sendPUT('companies/54' ,['title' => 'Qwerty1']);
$I->seeResponseCodeIs(200);

$I->sendPATCH('companies/54' ,['title' => 'Qwerty2']);
$I->seeResponseCodeIs(200);

$I->sendDELETE('companies/59' ,[]);
$I->seeResponseCodeIs(200);

$I->sendPUT('companies/58/undelete' ,[]);
$I->seeResponseCodeIs(200);

$I->deleteHeader('Content-Type');

/*
$I->amHttpAuthenticated('service_user', '123456');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('users', ['name' => 'davert', 'email' => 'davert@codeception.com']);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"result":"ok"}');
/**/

