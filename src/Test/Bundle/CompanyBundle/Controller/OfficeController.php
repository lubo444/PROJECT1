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

class OfficeController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc()
     */
    public function cgetAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);

        //company does'n exist
        if (!$company) {
            return $this->handleView($this->view());
        }

        //set object's associations to null (One-To-Many bidirectional - remove one direction)
        //error "A circular reference has been detected"
        $offices = $company->getOffices();
        foreach ($offices as $office) {
            $office->setIdCompany(null);
            $oh = $office->getOpeningHours();
            foreach ($oh as $hour) {
                $hour->setIdOffice(null);
            }
        }

        $view = $this->view($company, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO get user id
        $userId = 1;

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
        $address = $request->request->get('address');
        
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        $office->setAddress($address);
        
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
        $address = $request->request->get('address');
        
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        $office->setAddress($address);
        
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
        
        $em->remove($office);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

}
