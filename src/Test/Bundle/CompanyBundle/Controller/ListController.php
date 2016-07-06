<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\FilterType;
use Test\Bundle\CompanyBundle\Entity\Week;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

    /**
     * @Route("/company/{companyId}", requirements={"companyId" = "\d+"}, name="test_office_list")
     * @Template("TestCompanyBundle:Office:list.html.twig")
     */
    public function officesListAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();

        $offices = $em->getRepository('TestCompanyBundle:Office')->findBy([
            'idCompany' => $companyId
        ]);

        return [
            'offices' => $offices,
            'companyId' => $companyId
        ];
    }

    /**
     * @Route("/company/{companyId}/delete",
     *  requirements={"companyId" = "\d+"},
     *  name="test_company_delete")
     * @Template()
     */
    public function deleteCompanyAction($companyId)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);
        $em->remove($company);
        $em->flush();

        return $this->redirectToRoute('test_company_list');
    }

    /**
     * @Route("/office/{officeId}/delete", requirements={"officeId" = "\d+"}, name="test_office_delete")
     * @Template()
     */
    public function deleteOfficeAction($officeId)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        $companyId = $office->getIdCompany()->getIdCompany();

        $em->remove($office);
        $em->flush();

        return $this->redirectToRoute('test_office_list', array('companyId' => $companyId));
    }

    /**
     * @Route("/opening-hours/{openingHoursId}/delete", requirements={"openingHoursId" = "\d+"}, name="test_opnng_hours_delete")
     * @Template()
     */
    public function deleteOpeningHoursAction($openingHoursId)
    {
        $em = $this->getDoctrine()->getManager();
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($openingHoursId);

        $officeId = $openingHours->getIdOffice()->getIdOffice();

        $em->remove($openingHours);
        $em->flush();

        return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId));
    }

}
