<?php

class BasicCest
{

    const TOKEN = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
    
    public function _before(ApiTester $I)
    {
        
    }

    public function _after(ApiTester $I)
    {
        
    }

    /**
     * @example {"method":"POST", "route":"companies", "responseCode":"201", "title":"New Main Company" }
     * @example {"method":"PUT", "route":"companies/54", "responseCode":"200", "title":"Second Name Company" }
     * @example {"method":"PATCH", "route":"companies/54", "responseCode":"200", "title":"Third Name Company" }
     * @example {"method":"DELETE", "route":"companies/54", "responseCode":"200" }
     * @example {"method":"PUT", "route":"companies/54/undelete", "responseCode":"200" }
     */
    public function checkEndpointsWithAuth(ApiTester $I, \Codeception\Example $params)
    {
        $I->wantTo('Check endpoints method: ' . $params['method']);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(self::TOKEN);

        //$I->amHttpAuthenticated("admin", "aaaAAA111");

        $parameters = [];

        if (isset($params['title'])) {
            $parameters = ['title' => $params['title']];
        }

        switch ($params['method']) {
            case 'GET':
                $I->sendGET($params['route']);
                break;
            case 'POST':
                $I->sendPOST($params['route'], $parameters);
                break;
            case 'PUT':
                $I->sendPUT($params['route'], $parameters);
                break;
            case 'PATCH':
                $I->sendPATCH($params['route'], $parameters);
                break;
            case 'DELETE':
                $I->sendDELETE($params['route']);
                break;
            default:
                break;
        }

        $I->seeResponseCodeIs($params['responseCode']);

        $I->deleteHeader('Content-Type');
    }

    /**
     * @example {"route":"companiess", "responseCode":"200" }
     */
    public function checkGetEndpoint(ApiTester $I, \Codeception\Example $example)
    {
        $I->wantTo('Check GET method');
        $I->sendGET($example['route']);
        $I->seeResponseCodeIs($example['responseCode']);
    }
    
    /**
     * @example {"method":"POST", "route":"companies", "responseCode":"201", "title":"New Main Company" }
     */
    public function checkPostEndpoint(ApiTester $I, \Codeception\Example $example)
    {
        $I->wantTo('Check POST method');
        
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(self::TOKEN);
        
        $I->sendPOST($example['route'], ['title' => $example['title']]);
        $I->seeResponseCodeIs($example['responseCode']);
        
        $I->deleteHeader('Content-Type');
    }

}
