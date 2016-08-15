<?php 
$I = new FunctionalTester($scenario);

$I->wantTo('......LOGIN.......');
//$I->amOnPage('/');
//$I->seeResponseCodeIs(200);

$I->amOnPage('/login');

$I->fillField('_username', 'admin');
$I->fillField('_password', 'aaaAAA111');
$I->click('_submit');
$I->seeResponseCodeIs(200);

$I->amOnPage('/');
$I->click('Add new company');
$I->seeResponseCodeIs(200);

$I->amOnPage('/company/create');
$I->fillField('company[title]', 'adminTestuje');
$I->click('company[add_edit]');
$I->seeResponseCodeIs(200);

//$I->click('Enter');