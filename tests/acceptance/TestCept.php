<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('.............test Acceptance');

$I->amOnPage('/app_dev.php/');
$I->seeResponseCodeIs(200);
