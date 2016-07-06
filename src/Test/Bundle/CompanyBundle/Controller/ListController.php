<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Test\Bundle\CompanyBundle\Form\FilterType;
use Test\Bundle\CompanyBundle\Entity\Week;

class ListController extends Controller {

    /**
     * @Template("TestCompanyBundle:Homepage:list.html.twig")
     * @param Request $request
     * @return array
     */
    public function companiesListAction(Request $request, $page)
    {
        $form = $this->createForm(new FilterType());
        $form->handleRequest($request);
        
        $filters = [];
        
        if ($form->isSubmitted()) {
            $data = $form->getData();
            
            $filters['name'] = $data['title'];
            $filters['day'] = $data['day'];
            $filters['hour'] = $data['hour'];
        }
        
        $model = $this->get('test_company.web_model');
        $companies = $model->getCompanies($filters, $page);
        
        return [
            'companies' => $companies,
            'daysInWeek' => Week::getDaysInWeek(),
            'form' => $form->createView()
        ];
    }

    public function officesListAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();

        $offices = $em->getRepository('TestCompanyBundle:Office')->findBy(array('idCompany' => $companyId));

        return $this->render('TestCompanyBundle:Office:list.html.twig', array('offices' => $offices, 'companyId' => $companyId));
    }

    public function deleteCompanyAction($companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        $em->remove($company);
        $em->flush();

        return $this->redirectToRoute('test_company_homepage');
    }

    public function deleteOfficeAction($officeId)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        $companyId = $office->getIdCompany()->getIdCompany();

        $em->remove($office);
        $em->flush();

        return $this->redirectToRoute('test_company_list', array('companyId' => $companyId));
    }

    public function deleteOpeningHoursAction($openingHoursId)
    {
        $em = $this->getDoctrine()->getManager();
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($openingHoursId);

        $officeId = $openingHours->getIdOffice()->getIdOffice();

        $em->remove($openingHours);
        $em->flush();

        return $this->redirectToRoute('test_company_list', array('companyId' => $officeId));
    }

}
