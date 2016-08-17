<?php

class LoginCest
{

    public function _before(AcceptanceTester $I)
    {
        
    }

    public function _after(AcceptanceTester $I)
    {
        
    }

    public function tryLogin(AcceptanceTester $I)
    {

        $I->wantTo('Log in as admin...');
        
        $I->amOnPage('/login');
        $I->fillField('_username', 'admin');
        $I->fillField('_password', 'aaaAAA111');
        $I->click('_submit');

        //$content = $I->getContent();
        $I->amOnPage('/company/create');
        $I->see('Title');
        
        $I->fillField('company[title]', sq('DA_test'));
        $I->click('company[add_edit]');
        
        $content = $I->grabTextFrom('body');
        
        $I->comment('----start echo----');
        //var_dump($content);
        $I->comment('----end echo----');

    }

}
