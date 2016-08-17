<?php

use Codeception\Util\HttpCode;

class LoginCest
{

    public function _before(AcceptanceTester $I)
    {
        
    }

    public function _after(AcceptanceTester $I)
    {
        
    }

    /**
     * tests login from user interface and create one company as admin
     * @param AcceptanceTester $I
     */
    public function testLoginUI(AcceptanceTester $I)
    {
        $I->wantTo('Log in as admin...');
        
        $I->amOnPage('/login');
        $I->fillField('_username', 'admin');
        $I->fillField('_password', 'aaaAAA111');
        $I->click('_submit');

        $I->amOnPage('/company/create');
        $I->see('Title');
        
        $I->fillField('company[title]', 'Acceptance Test: New company');
        $I->click('company[add_edit]');
        
        //$content = $I->grabTextFrom('body');
        //var_dump($content);
        
        $I->seeResponseCodeIs(HttpCode::OK);
    }

}
