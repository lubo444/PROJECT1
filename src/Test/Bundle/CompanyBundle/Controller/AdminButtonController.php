<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Entity\Week;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminButtonController extends Controller {

    /**
     * @Route("/active-buttons/{itemId}/{routeAction}/{itemActive}/{itemCreatedBy}/", 
     *  requirements={"itemId" = "\d+", "routeAction" = "[a-z_\.]+", "itemActive" = "\d+", "itemCreatedBy" = "\d+"},
     *  name="test_active_buttons"
     *  )
     * @Template("TestCompanyBundle:Button:action_buttons.html.twig")
     */
    public function showAction($itemId, $routeAction, $itemActive, $itemCreatedBy)
    {
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return [];
        }
        
        $roleAdmin = false;
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $roleAdmin = true;
        }
        
        if (!$roleAdmin && $this->get('security.context')->isGranted('ROLE_USER')) {
            $loggedUserId = $this->get('security.context')->getToken()->getUser()->getId();
            
            if($itemCreatedBy != $loggedUserId){
                return [];
            }
        }
        
        return [
            'routeAction' => $routeAction,
            'itemId' => $itemId,
            'itemActive' => $itemActive,
            'roleAdmin' => $roleAdmin
        ];
    }

}
