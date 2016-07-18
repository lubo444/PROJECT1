<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\FilterType;
use Test\Bundle\CompanyBundle\Entity\Week;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Cache\ApcuCache;

class ListController extends Controller {

    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="test_company_list")
     * @Template("TestCompanyBundle:Homepage:list.html.twig")
     */
    public function companiesListAction(Request $request, $page)
    {
        $form = $this->createForm(new FilterType());
        $form->handleRequest($request);
        
        $filters = [];
        
        if($this->isGranted('ROLE_ADMIN')){
            $filters['roleAdmin'] = true;
        }
        
        if ($form->isSubmitted()) {
            $data = $form->getData();

            $filters['name'] = $data['title'];
            $filters['day'] = $data['day'];
            $filters['hour'] = $data['hour'];
        }

        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('TestCompanyBundle:Company')->getCompanies($filters, $page);

        return [
            'companies' => $companies,
            'daysInWeek' => Week::getDaysInWeek(),
            'form' => $form->createView(),
        ];
    }

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
        
        return [
            'offices' => $company->getOffices(),
            'company' => $company
        ];
    }
    
    
    /**
     * @Route("/office/{officeId}",
     *  requirements={"officeId" = "\d+"},
     *  name="test_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function openingHoursListAction(Request $request, $officeId)
    {
        $cacheManager = $this->get('test.cache_manager');
        
        $office = $cacheManager->getCachedObject('TestCompanyBundle:Office', $officeId);
        
        //check parents active status
        if(!$office || !$office->getActive()){
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        return [
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $office
        ];
    }
}
