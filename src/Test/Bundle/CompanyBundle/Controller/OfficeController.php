<?php

namespace Test\Bundle\CompanyBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\RestOfficeType;
use Test\Bundle\CompanyBundle\Entity\Office;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class OfficeController extends FOSRestController implements ClassResourceInterface
{

    
    /**
     * @Route("/company/{companyId}", requirements={"companyId" = "\d+"}, name="test_office_list")
     * @Template("TestCompanyBundle:Office:list.html.twig")
     */
    public function officesListAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();
        
        //check parents active status
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        
        if(!$company || !$company->getActive()){
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        //get data
        $qb = $em->createQueryBuilder();
        
        $qb->select('o')
            ->from('TestCompanyBundle:Office', 'o')
            ->innerJoin('o.idCompany', 'c')
            ->where('o.idCompany = :idCompany')
            ->setParameter('idCompany', $companyId);
        
        if(!$this->isGranted('ROLE_ADMIN')){
            $qb->andWhere('c.active = :active')
                ->andWhere('o.active = :active')
                ->setParameter('active', 1);
        }
        
        $offices = $qb->getQuery()->getResult();
        
        return [
            'offices' => $offices,
            'company' => $company
        ];
    }
    
    
    /**
     * @Route("/office/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_office_delete")
     * @Template()
     */
    public function deleteOfficeAction(Request $request, $itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($itemId);

        if (!$office) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($office);

        if ($undelete) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $office->setActive(true);
            }
        } else {
            $office->setActive(false);
        }

        $companyId = $office->getIdCompany()->getIdCompany();

        $em->persist($office);
        $em->flush();
        
        $cacheManager = $this->get('test.cache_manager');
        $cacheManager->deleteCachedObject('TestCompanyBundle:Office', $itemId);

        return $this->redirectToRoute('test_office_list', array('companyId' => $companyId), 301);
    }

    
    
    //////////////// REST ////////////////////////////////////
    
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
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        
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
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);
        $office->setActive(true);
        $em->persist($office);
        $em->flush();

        $view = $this->view([], Codes::HTTP_OK);
        return $this->handleView($view);
    }

}
