<?php

namespace Test\Bundle\CompanyBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Service("test_authorization")
 */
class Authorization
{

    private $authorizationChecker;
    private $securityContext;
    private $logger;

    public function __construct($authorizationChecker, $securityContext, $logger)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->securityContext = $securityContext;
        $this->logger = $logger;
    }

    public function checkAccessItem($item)
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->logger->error('Access denied, not authenticated user, class: ' . get_class($item) . ', ID ' . $item->getIdentifier());
            throw new AccessDeniedException();
        }

        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($this->securityContext->isGranted('ROLE_USER')) {
            $createdByUserId = $item->getCreatedBy();
            $loggedUserId = $this->securityContext->getToken()->getUser()->getId();

            if ($createdByUserId == $loggedUserId) {
                return true;
            }
        }

        $this->logger->error('Access denied, class: ' . get_class($item) . ', ID ' . $item->getIdentifier());
        throw new AccessDeniedException();
    }

    public function getAuthenticatedUserId()
    {
        if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->logger->error('Access denied, not authenticated user');
            throw new AccessDeniedException();
        }

        $authenticatedUserId = $this->securityContext->getToken()->getUser()->getId();

        return $authenticatedUserId;
    }

}
