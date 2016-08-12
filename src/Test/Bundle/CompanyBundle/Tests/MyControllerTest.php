<?php

namespace Test\Bundle\CompanyBundle\Tests;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Nelmio\ApiDocBundle\Tests\WebTestCase as ApiWebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Test\Bundle\CompanyBundle\Entity\Office;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class MyControllerTest extends WebTestCase
{

    private $client = null;
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

        $this->assertSame(200, $client->getResponse()->getStatusCode());


        $request = $client->request('GET', '/api/companies/' . $this->company . '/offices');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $request = $client->request('GET', '/api/companies/' . $data[1]->idCompany . '/offices');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @Route, name="test_routes2")
     */
    public function testCreateCompany()
    {
        //$this->logIn();
        
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('_submit')->form();
        
        $form['_username'] = 'admin';
        $form['_password'] = 'aaaAAA111';

        // submit the form
        $crawler = $client->submit($form);
        $response = $client->getResponse();
        
        $token = self::$kernel->getContainer()->get('security.context')->getToken();

        $this->assertSame(302, $response->getStatusCode());
        
        $crawler = $client->request('POST', '/api/companies', ['title'=>"test123"]);
                
        $this->assertSame(201, $client->getResponse()->getStatusCode());

    }
    
    public function setUp()
    {
        $this->client = static::createClient();
    }

    protected function getKernelConfiguration()
    {
        return array(
            'environment' => 'dev',
        );
    }
    
    

}
