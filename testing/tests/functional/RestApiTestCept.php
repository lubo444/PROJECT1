<?php

$I = new FunctionalTester($scenario);

$I->wantTo('create a user via API');
$I->amHttpAuthenticated('service_user', '123456');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('users', ['name' => 'mega', 'email' => 'mega@email.com']);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"result":"ok"}');

/*
$I->haveHttpHeader('X-Requested-With', 'Codeception');
$I->sendGET('companies');

$I->deleteHeader('X-Requested-With');
$I->sendPOST('companies/create');

$I->amOnPage('companies');



/*
$I->wantTo('perform actions and see result');
//$I->see('start apiss test');
//$I->amOnPage('companies');

$I->amOnPage('companies');
//$I->amOnPage('/companies/54/offices');

$I->sendGET('companies/54/offices');
$I->seeResponseContains(500);
/**/

/*
if ($I->dontSeeResponseCodeIs(500)) {
    Codeception\Util\Debug::debug('OK');
} else {
    Codeception\Util\Debug::debug('error');
}
/**/
//$I->dontSeeResponseCodeIs(500);
//$I->wantTo('test ok');