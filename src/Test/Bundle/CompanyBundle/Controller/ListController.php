<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller {

    public function companiesListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $query = $qb->select('c, o, oh')
                ->from('TestCompanyBundle:Company', 'c')
                ->leftJoin('c.offices', 'o')
                ->leftJoin('o.openingHours', 'oh')
                ->orderBy('c.title', 'ASC')
                ->getQuery();
        $companies = $query->getResult(); 
        /*
        echo '<pre>';
        dump($companies);
        echo '</pre>';
        die;/**/
        //$companies = $em->getRepository('TestCompanyBundle:Company')->findBy(array(), array('title' => 'ASC'));

        return $this->render('TestCompanyBundle:Homepage:list.html.twig', array('companies' => $companies));
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
