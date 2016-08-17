<?php


class MultiDataCest
{
    
    const AUTH_TOKEN = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
    
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * tests Api GET methods with permanent IDs
     * 
     * @example {"route":"/companies", "response":200}
     * @example {"route":"/companies/54/offices", "response": 200}
     * @example {"route":"/companies/54/offices/49/openinghours", "response": 200}
     */
    public function testGetMethods(ApiTester $I, \Codeception\Example $example)
    {
        $I->wantTo('Test of multiple examples');

        $I->sendGET($example['route']);

        $I->seeResponseCodeIs($example['response']);
    }
    
    /**
     * complete test of rest api methods
     * 
     * @example {"method":"POST", "route":"/companies", "responseCode":"201", "parameters":{"title":"New Main Company"} }
     * @example {"method":"PUT", "route":"/companies/54", "responseCode":"200", "parameters":{"title":"Second Name Company"} }
     * @example {"method":"PATCH", "route":"/companies/54", "responseCode":"200", "parameters":{"title":"Third Name Company"} }
     * @example {"method":"DELETE", "route":"/companies/54", "responseCode":"200", "parameters":{}}
     * @example {"method":"PUT", "route":"/companies/54/undelete", "responseCode":"200", "parameters":{}}
     */
    public function checkEndpointsWithAuth(ApiTester $I, \Codeception\Example $params)
    {
        $I->wantTo('Check endpoints method: ' . $params['method']);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(self::AUTH_TOKEN);

        $parameters = $params['parameters'];

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
    
}
