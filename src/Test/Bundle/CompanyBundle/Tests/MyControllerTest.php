<?php

namespace Test\Bundle\CompanyBundle\Tests;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Nelmio\ApiDocBundle\Tests\WebTestCase as ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Test\Bundle\CompanyBundle\Entity\Office;

class MyControllerTest extends WebTestCase
{

    private $company;
    
    /**
     * @Route("/test", name="test_routes")
     */
    public function testShowCompanies()
    {
        $client = static::createClient();

        $request = $client->request('GET', '/api/companies');
        $response = $client->getResponse();
        $data = json_decode($response->getContent());
        $this->company = $data[0]->idCompany;
        /*
        $this->assertTrue(
                $response->headers->contains(
                        'Content-Type', 'application/json'
                ), 'the "Content-Type" header is "application/json"'
        );
/***/
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        
        $request = $client->request('GET', '/api/companies/' . $this->company . '/offices');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        $request = $client->request('GET', '/api/companies/' . $data[1]->idCompany . '/offices');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
/**/
    }
    
    /**
     * @Route, name="test_routes2")
     */
    public function testShowOffice()
    {/*
        var_dump (1);
        
        $idCompany = $this->company;
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/companies/' . $idCompany . '/offices');
        $response = $client->getResponse();
        $data = json_decode($response->getContent());
        
        var_dump ($this->company);
        
        var_dump ('------------------------------------------------------');
        if(isset($data[0])){
            var_dump ('------------------------------------------------------');
            var_dump($data[0]->idOffice);
        }
        
        if(isset($data[1])){
            var_dump ('------------------------------------------------------');
            var_dump($data[1]->idOffice);
        }/**/

    }

    protected function getKernelConfiguration()
    {
        return array(
            'environment' => 'dev',
        );
    }

}
