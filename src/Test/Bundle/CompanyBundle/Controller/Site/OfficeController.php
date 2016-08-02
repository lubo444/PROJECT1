<?php

namespace Test\Bundle\CompanyBundle\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Form\OfficeType;
use Test\Bundle\CompanyBundle\Entity\Office;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OfficeController extends Controller
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

        if ((!$company || !$company->getActive()) && !$this->isGranted('ROLE_ADMIN')) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['companyId' => $companyId]);
        }

        //get data
        $qb = $em->createQueryBuilder();

        $qb->select('o')
                ->from('TestCompanyBundle:Office', 'o')
                ->innerJoin('o.idCompany', 'c')
                ->where('o.idCompany = :idCompany')
                ->setParameter('idCompany', $companyId);

        if (!$this->isGranted('ROLE_ADMIN')) {
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
     * @Route("/company/{companyId}/office/create", requirements={"companyId" = "\d+"}, name="test_office_create")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function registerOfficeAction(Request $request, $companyId)
    {
        $em = $this->getDoctrine()->getManager();

        $loggedUserId = $this->get('test.authorization')->getAuthenticatedUserId();

        $office = new Office();
        $office->setCreatedBy($loggedUserId);

        $form = $this->createForm(OfficeType::class, $office, ['block_name' => 'office']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData()->getAddress();

            $company = $em->getRepository('TestCompanyBundle:Company')->find($companyId);

            $office->setIdCompany($company);
            $office->setAddress($address);

            $em = $this->getDoctrine()->getManager();
            $em->persist($office);
            $em->flush();

            return $this->redirectToRoute('test_office_list', ['companyId' => $companyId], 301);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/office/{itemId}/edit", requirements={"itemId" = "\d+"}, name="test_office_edit")
     * @Template("TestCompanyBundle:Form:basic.html.twig")
     */
    public function officeEditAction(Request $request, $itemId)
    {
        $em = $this->getDoctrine()->getManager();
        $cacheManager = $this->get('test.cache_manager');

        $office = $em->getRepository('TestCompanyBundle:Office')->find($itemId);

        if (!$office) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['officeId' => $itemId]);
        }

        $this->get('test.authorization')->checkAccessItem($office);

        $form = $this->createForm(OfficeType::class, $office, ['block_name' => 'office']);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $companyId = $office->getIdCompany()->getIdCompany();

                $cacheManager->updateCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $office->getIdOffice());

                return $this->redirectToRoute('test_office_list', ['companyId' => $companyId], 301);
            }
        }

        return ['form' => $form->createView()];
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
            return $this->get('test.error_manager')->getFlashBagError('Object not found!', ['officeId' => $itemId]);
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
        $cacheManager->deleteCachedObject('Test\Bundle\CompanyBundle\Entity\Office', $itemId);

        return $this->redirectToRoute('test_office_list', array('companyId' => $companyId), 301);
    }

}
