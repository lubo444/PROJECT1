<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Test\Bundle\CompanyBundle\Entity\Week;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DetailController extends Controller {

    /**
     * @Route("/office/{officeId}", requirements={"officeId" = "\d+"}, name="test_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function showAction(Request $request, $officeId)
    {

        $em = $this->getDoctrine()->getManager();

        $days = $em->getRepository('TestCompanyBundle:OpeningHours')->findBy(
                ['idOffice' => $officeId], ['dayInWeek' => 'ASC']
        );

        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        return [
            'days' => $days,
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $office
        ];
    }
    
    /**
     * @Route("/company/{itemId}", requirements={"itemId" = "\d+"}, name="test_company_edit")
     * @Template("TestCompanyBundle:Form:rename.html.twig")
     */
    public function companyEditAction(Request $request, $itemId)
    {

        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('TestCompanyBundle:Company')->find($itemId);

        return [
            'title' => $company->getTitle()
        ];
    }

}
