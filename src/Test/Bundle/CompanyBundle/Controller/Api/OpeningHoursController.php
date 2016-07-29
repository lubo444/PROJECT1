<?php

namespace Test\Bundle\CompanyBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Test\Bundle\CompanyBundle\Form\RestOpeningHoursType;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;


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
        
        $criteria['idOffice'] = $officeId;
        
        if(!$this->get('test.authorization')->isUserLoggedIn() || !$this->isGranted('ROLE_ADMIN')){
            $criteria['active'] = 1;
        }

        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->findBy($criteria, ['dayInWeek'=>'ASC']);
        
        $view = $this->view($opnngHrs, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request, $companyId, $officeId)
    {
        $userId = $this->get('test.authorization')->getAuthenticatedUserId();
        
        $em = $this->getDoctrine()->getManager();

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
        
        $this->get('test.authorization')->checkAccessItem($opnngHrs);

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

        $this->get('test.authorization')->checkAccessItem($opnngHrs);
        
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

        $this->get('test.authorization')->checkAccessItem($opnngHrs);
        
        $opnngHrs->setActive(false);

        $em->persist($opnngHrs);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     * 
     * @Rest\Put("/companies/{companyId}/offices/{officeId}/openinghours/{opnngHrsId}/undelete")
     */
    public function undeleteAction(Request $request, $companyId, $officeId, $opnngHrsId)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            $view = $this->view(null, Codes::HTTP_UNAUTHORIZED);
            return $this->handleView($view);
        }
        
        $em = $this->getDoctrine()->getManager();
        $opnngHrs = $em->getRepository('TestCompanyBundle:OpeningHours')->find($opnngHrsId);

        $opnngHrs->setActive(true);

        $em->persist($opnngHrs);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }
    

}
