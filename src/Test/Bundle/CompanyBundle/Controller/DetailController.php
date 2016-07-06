<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DetailController extends Controller {

    public function showAction(Request $request, $officeId)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $days = $em->getRepository('TestCompanyBundle:OpeningHours')->findBy(
            array('idOffice' => $officeId),
            array('dayInWeek' => 'ASC')
        );
        
        $office = $em->getRepository('TestCompanyBundle:Office')->find($officeId);

        $daysInWeek = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        );
        
        return $this->render('TestCompanyBundle:Office:detail.html.twig',
            array(
                'days' => $days,
                'daysInWeek' => $daysInWeek,
                'office' => $office
            )
        );
    }

}
