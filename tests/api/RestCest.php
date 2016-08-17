<?php

use Codeception\Util\HttpCode;

class RestCest
{

    const COUNT_RAND_COMPANIES = 2;
    const AUTH_TOKEN = 'NDU1OWZkYmJkODNmZTQwNzE3YTA0MThkYjk4ZDg5MzNkOGY2Yjc5MjEzYWQwZGE5YzM3ZTg4ZTIxNTI0ZjIyMw';
    const TEST_COMPANY_ID = 54;

    public function _before(ApiTester $I)
    {
        
    }

    public function _after(ApiTester $I)
    {
        
    }

    /**
     * tests Rest Api Methods
     * @param ApiTester $I
     */
    public function testRestApi(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->amBearerAuthenticated(self::AUTH_TOKEN);

        $I->sendPOST('/companies', ['title' => 'codeceptionTest']);
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->sendPUT('/companies/' . self::TEST_COMPANY_ID, ['title' => 'Change name 1']);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPATCH('/companies/' . self::TEST_COMPANY_ID, ['title' => 'Change name 2']);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendDELETE('/companies/' . self::TEST_COMPANY_ID, []);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendPUT('/companies/' . self::TEST_COMPANY_ID . '/undelete', []);
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->deleteHeader('Content-Type');
    }

    /**
     * tests n randomly offices from list of companies
     * @param ApiTester $I
     */
    public function getRandomOffices(ApiTester $I)
    {
        $I->sendGET('/companies');
        $I->seeResponseCodeIs(HttpCode::OK);

        $companyIds = [];
        $companies = $I->grabDataFromResponseByJsonPath("$")[0];
        foreach ($companies as $company) {
            $companyIds[] = $company['idCompany'];
        }

        //get n randomly company IDs
        $companiesRandIds = array_rand($companyIds, self::COUNT_RAND_COMPANIES);

        foreach ($companiesRandIds as $companiesRandId) {
            //get detail of company
            $I->sendGET('/companies/' . $companiesRandId . '/offices');
            $offices = $I->grabDataFromResponseByJsonPath("$")[0];

            //default report
            $report = 'Company without office';

            //get address of one randomly office
            $officesCount = count($offices);
            if ($officesCount > 0) {
                $officesRandomIds = rand(0, $officesCount - 1);
                $report = 'Testing office: (' 
                        . $offices[$officesRandomIds]['idOffice'] . ')' 
                        . $offices[$officesRandomIds]['address'];
            } 

            $I->comment($report);
        }
    }

}
