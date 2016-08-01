<?php

namespace Test\Bundle\CompanyBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestOfficeType;
use Test\Bundle\CompanyBundle\Entity\Office;
use Symfony\Component\Routing\Annotation\Route;

class OfficeController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc()
     */
    public function cgetAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        
        $criteria['idCompany'] = $companyId;
        
        if(!$this->get('test.authorization')->isUserLoggedIn() || !$this->isGranted('ROLE_ADMIN')){
            $criteria['active'] = 1;
        }
        
        $offices = $em->getRepository('TestCompanyBundle:Office')->getOfficeDetails($companyId);
        
        $view = $this->view($offices, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request, $companyId)
    {
        $userId = $this->get('test.authorization')->getAuthenticatedUserId();
        
        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        
        $office = new Office();
        $office->setIdCompany($company);
        $office->setCreatedBy($userId);
        
        $form = $this->get('form.factory')->createNamed(null, new RestOfficeType(), $office);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($office);
            $em->flush();

            $view = $this->view(['id' => $office->getIdOffice()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }
    
    /**
     * @ApiDoc()
     */
    public function putAction(Request $request, $companyId, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        
        $this->get('test.authorization')->checkAccessItem($office);
        
        $form = $this->get('form.factory')->createNamed(null, new RestOfficeType(), $office);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($office);
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
    public function patchAction(Request $request, $companyId, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        
        $this->get('test.authorization')->checkAccessItem($office);
        
        $form = $this->get('form.factory')->createNamed(null, new RestOfficeType(), $office);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($office);
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
    public function deleteAction(Request $request, $companyId, $officeId)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        
        $this->get('test.authorization')->checkAccessItem($office);
        
        $office->setActive(false);
        $em->persist($office);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }
    
    /**
     * @ApiDoc()
     * 
     * @Rest\Put("/companies/{companyId}/offices/{officeId}/undelete")
     */
    public function undeleteAction(Request $request, $companyId, $officeId)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            $view = $this->view(null, Codes::HTTP_UNAUTHORIZED);
            return $this->handleView($view);
        }
        
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        $office->setActive(true);
        $em->persist($office);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

}
