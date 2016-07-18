<?php

namespace Test\Bundle\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestCompanyType;
use Test\Bundle\CompanyBundle\Entity\Company;

class CompanyController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc()
     */
    public function cgetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filters = [];

        $page = $request->query->get('page');
        if ($page <= 0) {
            $page = 1;
        }
        /*
          if ($this->isGranted('ROLE_ADMIN')) {
          $filters['roleAdmin'] = true;
          }
          //* */
        $filters['name'] = $request->query->get('name');
        $filters['day'] = $request->query->get('day');
        $filters['hour'] = $request->query->get('hour');

        $companies = $em->getRepository('TestCompanyBundle:Company')->getCompanies($filters, $page);
        
        //set object's associations to null (One-To-Many bidirectional - remove one direction)
        //error "A circular reference has been detected"
        foreach($companies as $company){
            $offices = $company->getOffices();
            foreach ($offices as $office) {
                $office->setIdCompany(null);
                $oh = $office->getOpeningHours();
                foreach ($oh as $hour) {
                    $hour->setIdOffice(null);
                }
            }
        }
        
        $view = $this->view($companies, 200);
        
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function postAction(Request $request)
    {
        //TODO get user id
        $userId = 1;

        $company = new Company();
        $company->setCreatedBy($userId);
        $form = $this->get('form.factory')->createNamed(null, new RestCompanyType(), $company);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            $view = $this->view(['id' => $company->getIdCompany()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc()
     */
    public function putAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);

        $form = $this->get('form.factory')->createNamed(null, new RestCompanyType(), $company);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($company);
            $em->flush();

            $view = $this->view(['id' => $company->getIdCompany()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }
    
    /**
     * @ApiDoc()
     */
    public function patchAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        
        $form = $this->get('form.factory')->createNamed(null, new RestCompanyType(), $company);
        $form->submit($request);

        if ($form->isValid()) {
            $em->persist($company);
            $em->flush();

            $view = $this->view(['id' => $company->getIdCompany()], Codes::HTTP_CREATED);
            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }
    
    /**
     * @ApiDoc()
     */
    public function deleteAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        $company->setActive(false);
        $em->persist($company);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }
    

}
