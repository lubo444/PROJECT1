<?php

namespace Test\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Test\Bundle\CompanyBundle\Form\RestOpeningHoursType;
use Test\Bundle\CompanyBundle\Entity\OpeningHours;
use Test\Bundle\CompanyBundle\Entity\Week;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as BaseRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @RouteResource("OpeningHours")
 */
class OpeningHoursController extends Controller
{

    /**
     * @BaseRoute("/office/{officeId}",
     *  requirements={"officeId" = "\d+"},
     *  name="test_opnng_hrs")
     * @Template("TestCompanyBundle:Office:detail.html.twig")
     */
    public function openingHoursListAction(Request $request, $officeId)
    {
        $cacheManager = $this->get('test.cache_manager');
        
        $office = $cacheManager->getCachedObject('TestCompanyBundle:Office', $officeId);
        
        //check parents active status
        if(!$office || !$office->getActive() || !$office->getIdCompany()->getActive()){
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        return [
            'daysInWeek' => Week::getDaysInWeek(),
            'office' => $office
        ];
    }
    
    /**
     * @BaseRoute("/opening-hours/{itemId}/delete/{undelete}",
     *  requirements={"itemId" = "\d+", "undelete" = "\d+"},
     *  defaults={"undelete" = null},
     *  name="test_opening_hours_delete")
     * @Template()
     */
    public function deleteOpeningHoursAction(Request $request, $itemId, $undelete)
    {
        $em = $this->getDoctrine()->getManager();
        $openingHours = $em->getRepository('TestCompanyBundle:OpeningHours')->find($itemId);

        if (!$openingHours) {
            return $this->get('test.error_manager')->getFlashBagError('Object not found!');
        }
        
        $this->get('test.authorization')->checkAccessItem($openingHours);

        if ($undelete) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $openingHours->setActive(true);
            }
        } else {
            $openingHours->setActive(false);
        }

        $officeId = $openingHours->getIdOffice()->getIdOffice();

        $em->persist($openingHours);
        $em->flush();

        return $this->redirectToRoute('test_opnng_hrs', array('officeId' => $officeId), 301);
    }
    
    
    
    

}
