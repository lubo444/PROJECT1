<?php

namespace Test\Bundle\CompanyBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Service("test_authorization")
 */
class Authorization {

    private $authorizationChecker;
    private $securityContext;
    
    public function setAuthorizationChecker($authorizationChecker){
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public function setSecurityContext($securityContext){
        $this->securityContext = $securityContext;
    }
    
    public function checkAccessItem($item)
    {
        if(!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')){
            throw new AccessDeniedException();
        }
        
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        }
        
        if ($this->securityContext->isGranted('ROLE_USER')) {
            $createdByUserId = $item->getCreatedBy();
            $loggedUserId = $this->securityContext->getToken()->getUser()->getId();
            
            if($createdByUserId == $loggedUserId){
                return true;
            }
        }
        
        throw new AccessDeniedException();
    }

}
