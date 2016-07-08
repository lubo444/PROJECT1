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
            return $this->redirectToRoute('test_company_list');
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
     * @Route("/office/{officeId}",
     *  requirements={"officeId" = "\d+"},
     *  name="test_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function openingHoursListAction(Request $request, $officeId)
    {
        $em = $this->getDoctrine()->getManager();
        
        //check parents active status
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        if(!$office || !$office->getActive() || !$office->getIdCompany()->getActive()){
            return $this->redirectToRoute('test_company_list');
        }
        
        //get data
        $qb = $em->createQueryBuilder();
        
        $qb->select('oh')
            ->from('TestCompanyBundle:OpeningHours', 'oh')
            ->innerJoin('oh.idOffice', 'o', 'WITH', 'oh.idOffice = o.idOffice')
            ->innerJoin('o.idCompany', 'c')
            ->where('oh.idOffice = :idOffice')
            ->setParameter('idOffice', $officeId);
        
        if(!$this->isGranted('ROLE_ADMIN')){
            $qb->andWhere('c.active = :active')
                ->andWhere('o.active = :active')
                ->andWhere('oh.active = :active')
                ->setParameter('active', 1);
        }
        
        $days = $qb->getQuery()->getResult();

        return [
            'days' => $days,
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $office
        ];
    }

    /**
     * @Route("/company/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_company_delete")
     * @Template()
     */
    public function deleteCompanyAction($itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TestCompanyBundle:Company')->find($itemId);
        
        $this->get('test.authorization')->checkAccessItem($company);

        if($undelete){
            if($this->isGranted('ROLE_ADMIN')){
                $company->setActive(true);
            }
        }
        else{
            $company->setActive(false);
        }
        
        $em->persist($company);
        $em->flush();

        return $this->redirectToRoute('test_company_list');
    }

    /**
     * @Route("/office/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_office_delete")
     * @Template()
     */
    public function deleteOfficeAction($itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $office = $em->getRepository('TestCompanyBundle:Office')->find($itemId);
        
        $this->get('test.authorization')->checkAccessItem($office);
        
        if($undelete){
            if($this->isGranted('ROLE_ADMIN')){
                $office->setActive(true);
            }
        }
        else{
            $office->setActive(false);
        }

        $companyId = $office->getIdCompany()->getIdCompany();

        $em->persist($office);
        $em->flush();

        return $this->redirectToRoute('test_office_list', array('companyId' => $companyId));
    }

    /**
     * @Route("/opening-hours/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_opening_hours_delete")
     * @Template()
     */
    public function deleteOpeningHoursAction($itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($itemId);
        
        $this->get('test.authorization')->checkAccessItem($openingHours);
        if($undelete){
            if($this->isGranted('ROLE_ADMIN')){
                $openingHours->setActive(true);
            }
        }
        else{
            $openingHours->setActive(false);
        }

        $officeId = $openingHours->getIdOffice()->getIdOffice();

        $em->persist($openingHours);
        $em->flush();

        return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId));
    }
}
