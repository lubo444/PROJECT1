<?php

namespace Test\Bundle\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestOpeningHoursType;
use Test\Bundle\CompanyBundle\Entity\Company;
use Test\Bundle\CompanyBundle\Entity\Office;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;
use Test\Bundle\CompanyBundle\Entity\Week;

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

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request, $companyId, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO get user id
        $userId = 1;

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        $opnngHrs = new OpeningHours();
        $opnngHrs->setIdOffice($office);
        $opnngHrs->setCreatedBy($userId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType(), $opnngHrs);
        $form->submit($request);
        
        if ($form->isValid()) {
            $em->persist($opnngHrs);
            $em->flush();

            $view = $this->view(['id' => $opnngHrs->getIdOpnngHrs()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function putAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();

        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType('PUT'), $opnngHrs, ['method' => 'PUT']);
        $form->submit($request);

        if ($form->isValid()) {
            $em->merge($opnngHrs);
            $em->flush();
            
            $view = $this->view([], Codes::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function patchAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();

        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $form = $this->get('form.factory')->createNamed(null, new RestOpeningHoursType(), $opnngHrs);
        $form->submit($request);
        
        if ($form->isValid()) {
            $em->persist($opnngHrs);
            $em->flush();

            $view = $this->view([], Codes::HTTP_OK);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function deleteAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        $em = $this->getDoctrine()->getManager();
        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);
        
        $opnngHrs->setActive(false);

        $em->persist($opnngHrs);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

}
