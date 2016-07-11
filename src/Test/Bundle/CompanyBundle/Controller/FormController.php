<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Entity\Company;
use Test\Bundle\CompanyBundle\Form\CompanyType;
use Test\Bundle\CompanyBundle\Entity\Office;
use Test\Bundle\CompanyBundle\Form\OfficeType;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;
use Test\Bundle\CompanyBundle\Form\OpeningHoursType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FormController extends Controller
{

    /**
     * @Route("/company/create", name="test_company_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();

        $company = new Company($loggedUserId);
        $form = $this->createForm(new CompanyType(), $company);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form->getData()->getTitle();
            $company->setTitle($title);

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('test_company_list', array(), 201);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/company/{companyId}/office/create", requirements={"companyId" = "\d+"}, name="test_office_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerOfficeAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();

        $office = new Office($loggedUserId);
        $form = $this->createForm(new OfficeType(), $office);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData()->getAddress();

            $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);

            $office->setIdCompany($company);
            $office->setAddress($address);

            $em = $this->getDoctrine()->getManager();
            $em->persist($office);
            $em->flush();

            return $this->redirectToRoute('test_office_list', ['companyId' => $companyId], 201);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/office/{officeId}/opening-hours/create", requirements={"officeId" = "\d+"}, name="test_opening_hours_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerOpeningHoursAction(Request $request, $officeId)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();
        $opnngHours = new OpeningHours($loggedUserId);

        $form = $this->createForm(new OpeningHoursType(), $opnngHours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startAt = $data->getStartAt();
            $startLunchAt = $data->getLunchStartAt();
            $endLunchAt = $data->getLunchEndAt();
            $endAt = $data->getEndAt();

            $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

            $opnngHours->setIdOffice($office);
            $opnngHours->setStartAt($startAt);
            $opnngHours->setLunchStartAt($startLunchAt);
            $opnngHours->setLunchEndAt($endLunchAt);
            $opnngHours->setEndAt($endAt);

            $em = $this->getDoctrine()->getManager();
            $em->persist($opnngHours);
            $em->flush();

            return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId), 201);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/opening-hours/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_opening_hours_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function editOpeningHoursAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();

        $opnngHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($itemId);
        if (!$opnngHours) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($opnngHours);

        $form = $this->createForm(new OpeningHoursType(), $opnngHours);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $officeId = $form->getData()->getIdOffice()->getIdOffice();
                $em->flush();

                return $this->redirectToRoute('test_opnng_hrs', ['officeId' => $officeId], 201);
            }
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/company/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_company_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function companyEditAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('TestCompanyBundle:Company')->find($itemId);

        if (!$company) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($company);

        $form = $this->createForm(new CompanyType(), $company);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('test_company_list', array(), 201);
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/office/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_office_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function officeEditAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();

        $office = $em->getRepository('TestCompanyBundle:Office')->find($itemId);

        if (!$office) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }

        $this->get('test.authorization')->checkAccessItem($office);

        $form = $this->createForm(new OfficeType(), $office);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $companyId = $office->getIdCompany()->getIdCompany();

                return $this->redirectToRoute('test_office_list', ['companyId' => $companyId], 201);
            }
        }

        return [
            'form' => $form->createView()
        ];
    }

}
