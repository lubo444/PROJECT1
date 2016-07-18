<?php

namespace Test\Bundle\CompanyBundle\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;

class ErrorManager
{
    private $session;
    private $logger;
    private $router;

    public function __construct($session, $logger, $router)
    {
        $this->session = $session;
        $this->logger = $logger;
        $this->router = $router;
    }

    public function getFlashBagError($msg)
    {
        $this->logger->error($msg);
        $this->session->getFlashBag()->add('error', $msg);
        
        return new RedirectResponse($this->router->generate('test_company_list'));
    }

}
