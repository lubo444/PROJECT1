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

}
