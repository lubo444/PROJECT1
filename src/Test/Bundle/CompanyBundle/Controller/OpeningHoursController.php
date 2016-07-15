<?php

namespace Test\Bundle\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestOfficeType;
use Test\Bundle\CompanyBundle\Entity\Company;
use Test\Bundle\CompanyBundle\Entity\Office;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * @RouteResource("OpeningHours")
 */
class OpeningHoursController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc()
     */
    public function cgetAction(Request $request, $companyId, $officeId)
    {
        
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        //company does'n exist
        if (!$office) {
            return $this->handleView($this->view());
        }

        //set object's associations to null (One-To-Many bidirectional - remove one direction)
        //error "A circular reference has been detected"

        $office->setIdCompany(null);
        $oh = $office->getOpeningHours();
        foreach ($oh as $hour) {
            $hour->setIdOffice(null);
        }

        $view = $this->view($office, 200);
        return $this->handleView($view);
    }

    

}
